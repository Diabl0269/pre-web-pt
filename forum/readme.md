### Forum Finale - Written by Tal Efronny

This is my final project for the Introduction for Web Pen Testing course.  
The project is a forum with topics, with an ability to manage the topics as an admin user, you can create new topics, edit existing ones and delete them.  
Notice that deleting a topic will also delete all it's related messages.

#### Admin user - admin@admin.com:Admin1!

The preferred way to run this project is by running

```
docker-compose up
```

The site will be available on port `5000` and `phpMyAdmin` will be on port `8080`, MySQL will be on it's default port, `3306`.

### Pages:

1. Login/Register
2. Topcis Selection Page
3. Specific Topic Page
4. Profile
5. Admin Panel - Allow to manage topics

### Schemas:

User Schema:

1. id - int, unique
2. username - string, max length 20
3. password - string, max length 30
4. displayName - string, max length 30
5. role - boolean (user/admin)

Topic Schema:

1. id - int, unique
2. name - string, unique, max 50
3. description - string, max 200

Message Schema:

1. topicId - int, relates to the topic
2. userId - int, the ID of the user created the message
3. content - string, min 2, max 500
