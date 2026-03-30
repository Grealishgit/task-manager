Hunter@DESKTOP-QM2MQ3M MINGW64 ~/Documents/Project/task manager
$ curl http://127.0.0.1:9000/api/tasks -H "Accept: application/json"
{"message":"No tasks found.","data":[]}
Hunter@DESKTOP-QM2MQ3M MINGW64 ~/Documents/Project/task manager
$ curl -X POST http://127.0.0.1:9000/api/tasks \
 -H "Content-Type: application/json" \
 -H "Accept: application/json" \
 -d '{"title":"Fix login bug","due_date":"2026-04-01","priority":"high"}'
{"message":"Task created successfully.","data":{"title":"Fix login bug","due_date":"2026-04-01T00:00:00.000000Z","priority":"high","status":"pending","updated_at":"2026-03-30T09:29:46.000000Z","created_at":"2026-03-30T09:29:46.000000Z","id":1}}
Hunter@DESKTOP-QM2MQ3M MINGW64 ~/Documents/Project/task manager
$ curl http://127.0.0.1:9000/api/tasks \
 -H "Accept: application/json"
{"message":"Tasks retrieved successfully.","data":[{"id":1,"title":"Fix login bug","due_date":"2026-04-01T00:00:00.000000Z","priority":"high","status":"pending","created_at":"2026-03-30T09:29:46.000000Z","updated_at":"2026-03-30T09:29:46.000000Z"}]}
Hunter@DESKTOP-QM2MQ3M MINGW64 ~/Documents/Project/task manager
$ curl -X POST http://127.0.0.1:9000/api/tasks \
 -H "Content-Type: application/json" \
 -H "Accept: application/json" \
 -d '{"title":"Write unit tests","due_date":"2026-04-01","priority":"low"}'
{"message":"Task created successfully.","data":{"title":"Write unit tests","due_date":"2026-04-01T00:00:00.000000Z","priority":"low","status":"pending","updated_at":"2026-03-30T09:30:20.000000Z","created_at":"2026-03-30T09:30:20.000000Z","id":2}}
Hunter@DESKTOP-QM2MQ3M MINGW64 ~/Documents/Project/task manager
$ curl -X POST http://127.0.0.1:9000/api/tasks \
 -H "Content-Type: application/json" \
 -H "Accept: application/json" \
 -d '{"title":"Fix login bug","due_date":"2026-04-01","priority":"high"}'
{"message":"A task with this title already exists for the given due date.","errors":{"title":["A task with this title already exists for the given due date."]}}
Hunter@DESKTOP-QM2MQ3M MINGW64 ~/Documents/Project/task manager
$ curl -X POST http://127.0.0.1:9000/api/tasks \
 -H "Content-Type: application/json" \
 -H "Accept: application/json" \
 -d '{"title":"Fix login bug","due_date":"2026-04-01","priority":"high"}'
{"message":"A task with this title already exists for the given due date.","errors":{"title":["A task with this title already exists for the given due date."]}}
Hunter@DESKTOP-QM2MQ3M MINGW64 ~/Documents/Project/task manager
$ curl -X POST http://127.0.0.1:9000/api/tasks \
 -H "Content-Type: application/json" \
 -H "Accept: application/json" \
 -d '{"title":"Old task","due_date":"2026-01-01","priority":"high"}'
{"message":"This is due date which must be today or a future date.","errors":{"due_date":["This is due date which must be today or a future date."]}}
Hunter@DESKTOP-QM2MQ3M MINGW64 ~/Documents/Project/task manager
$ curl http://127.0.0.1:9000/api/tasks \
 -H "Accept: application/json"
{"message":"Tasks retrieved successfully.","data":[{"id":1,"title":"Fix login bug","due_date":"2026-04-01T00:00:00.000000Z","priority":"high","status":"pending","created_at":"2026-03-30T09:29:46.000000Z","updated_at":"2026-03-30T09:29:46.000000Z"},{"id":2,"title":"Write unit tests","due_date":"2026-04-01T00:00:00.000000Z","priority":"low","status":"pending","created_at":"2026-03-30T09:30:20.000000Z","updated_at":"2026-03-30T09:30:20.000000Z"}]}
Hunter@DESKTOP-QM2MQ3M MINGW64 ~/Documents/Project/task manager
$ curl -X PATCH http://127.0.0.1:9000/api/tasks/1/status \
 -H "Accept: application/json"
{"message":"Task status updated to 'in_progress'.","data":{"id":1,"title":"Fix login bug","due_date":"2026-04-01T00:00:00.000000Z","priority":"high","status":"in_progress","created_at":"2026-03-30T09:29:46.000000Z","updated_at":"2026-03-30T09:31:31.000000Z"}}
Hunter@DESKTOP-QM2MQ3M MINGW64 ~/Documents/Project/task manager
$ curl -X PATCH http://127.0.0.1:9000/api/tasks/1/status \
 -H "Accept: application/json"
-H "Accept: application/json"
{"message":"Task status updated to 'in_progress'.","data":{"id":1,"title":"Fix login bug","due_date":"2026-04-01T00:00:00.000000Z","priority":"high","status":"in_progress","created_at":"2026-03-30T09:29:46.000000Z","updated_at":"2026-03-30T09:31:31.000000Z"}}
Hunter@DESKTOP-QM2MQ3M MINGW64 ~/Documents/Project/task manager
$ curl -X PATCH http://127.0.0.1:9000/api/tasks/1/status \
 -H "Accept: application/json"
{"message":"Task status updated to 'done'.","data":{"id":1,"title":"Fix login bug","due_date":"2026-04-01T00:00:00.000000Z","priority":"high","status":"done","created_at":"2026-03-30T09:29:46.000000Z","updated_at":"2026-03-30T09:31:37.000000Z"}}
Hunter@DESKTOP-QM2MQ3M MINGW64 ~/Documents/Project/task manager
$ curl -X PATCH http://127.0.0.1:9000/api/tasks/1/status \
 -H "Accept: application/json"
$ curl -X PATCH http://127.0.0.1:9000/api/tasks/1/status \
 -H "Accept: application/json"
{"message":"Task status updated to 'done'.","data":{"id":1,"title":"Fix login bug","due_date":"2026-04-01T00:00:00.000000Z","priority":"high","status":"done","created_at":"2026-03-30T09:29:46.000000Z","updated_at":"2026-03-30T09:31:37.000000Z"}}
Hunter@DESKTOP-QM2MQ3M MINGW64 ~/Documents/Project/task manager
$ curl -X PATCH http://127.0.0.1:9000/api/tasks/1/status \
 -H "Accept: application/json"
{"message":"Task is already marked as done. No further status changes allowed."}
Hunter@DESKTOP-QM2MQ3M MINGW64 ~/Documents/Project/task manager
$ curl -X DELETE http://127.0.0.1:9000/api/tasks/2 \
 -H "Accept: application/json"
{"message":"Only tasks with status \"done\" can be deleted."}
Hunter@DESKTOP-QM2MQ3M MINGW64 ~/Documents/Project/task manager
$ curl -X DELETE http://127.0.0.1:9000/api/tasks/1 \
 -H "Accept: application/json"
{"message":"Task deleted successfully."}
Hunter@DESKTOP-QM2MQ3M MINGW64 ~/Documents/Project/task manager
$ curl "http://127.0.0.1:9000/api/tasks/report?date=2026-04-01" \
 -H "Accept: application/json"
{"date":"2026-04-01","summary":{"high":{"pending":0,"in_progress":0,"done":0},"medium":{"pending":0,"in_progress":0,"done":0},"low":{"pending":1,"in_progress":0,"done":0}}}
Hunter@DESKTOP-QM2MQ3M M
