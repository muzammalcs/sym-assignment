# sym-assignment
Symfony application with 2 microservices that communicate via message bus.

There two Symfony projects:
**users
notifications**

Docker file is included. 

**Steps to run this assiggnment:**

1- Pull the git repo.
2- Build the docker container using command: docker-compose build
3- Run the docuer using command: docker-compose up -d

**Testing the Application**
You can now test the application by sending a POST request to the "users" service:

curl -X POST http://localhost:8000/users \
    -H "Content-Type: application/json" \
    -d '{"email": "test@example.com", "firstName": "John", "lastName": "Doe"}'

Check the log files in users-service/var/log/users.log and notifications-service/var/log/notifications.log to see the logged data.
