<!DOCTYPE html>
<html>
<head>
    <title>Task In Progress Notification</title>
</head>
<body>
    <h2>Task In Progress Notification</h2>  
    <p>Dear {{ $task->user->name }},</p>
    <p>Your task "{{ $task->title }}" is still in progress.</p>
    <p>Best regards,<br>Your Task Management Team</p>
</body>
</html>
