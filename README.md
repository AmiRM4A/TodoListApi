# TodoList API 📝

This API provides endpoints for user management, task management, and authentication, making it ideal for integration into various applications that require task and user tracking.

## 📘 Table of Contents

- [Project Details](#project-details) <!-- Anchor for Project Details section -->
- [Dependencies](#dependencies) <!-- Anchor for Dependencies section -->
- [Usage](#usage) <!-- Anchor for Usage section -->
    - [User Endpoints](#user-endpoints) <!-- Anchor for User Endpoints subsection -->
    - [Task Endpoints](#task-endpoints) <!-- Anchor for Task Endpoints subsection -->
    - [Authentication Endpoints](#authentication-endpoints) <!-- Anchor for Authentication Endpoints subsection -->
- [Contact](#contact) <!-- Anchor for Contact section -->

 <!-- Project Details section -->
## 🔖 Project Details

<div id="project-details">

- **Name:** TodoList API
- **License:** [MIT License](https://opensource.org/licenses/MIT)
- **Version:** 1.0.0

</div>

 <!-- Dependencies section -->
## ⚙️ Dependencies

<div id="dependencies">

This API utilizes the following dependencies:

- [Medoo](https://github.com/catfan/Medoo) Library for working with sql database and queries (^2.1)
- [Dotenv](https://github.com/symfony/dotenv) For storing environment variables (^7.0)
- [Agent](https://github.com/jenssegers/agent) For having some information about user's agent (^2.6)

</div>

 <!-- Usage section -->
## 🚀 Usage

<div id="usage">

To get started with the TodoList API, follow these steps:

1. Clone the repository: `git clone https://github.com/AmiRM4A/Todolist-api.git`
2. Install dependencies: `composer install`
3. Set up the required environment variables (e.g., database connection string, JWT secret)

</div>

 <!-- User Endpoints Subsection -->
### 👥 User Endpoints

<div style="text-align:center" id="user-endpoints">

| Endpoint           | HTTP Method | Description                         | Required Auth |
|--------------------|-------------|-------------------------------------|---------------|
| `/get-users`       | GET         | Get all users 👥                    | ✅             |
| `/get-user/{id}`   | GET         | Get a specific user by ID 👤        | ✅             |
| `/create-user`     | POST        | Create a new user ➕                 | ❌             |
| `/remove-user/{id}`| DELETE      | Delete an existing user by ID ❌     | ✅             |
| `/update-user/{id}`| PUT         | Update an existing user by ID ✏️    | ✅             |

</div>

 <!-- Task Endpoints Subsection -->
### 📄 Task Endpoints

<div style="text-align:center" id="task-endpoints">

| Endpoint           | HTTP Method | Description                         | Required Auth |
|--------------------|-------------|-------------------------------------|---------------|
| `/get-tasks`       | GET         | Get all tasks 📄                    | ✅             |
| `/get-task/{id}`   | GET         | Get a specific task by ID 📇        | ✅             |
| `/create-task`     | POST        | Create a new task ➕                 | ✅             |
| `/remove-task/{id}`| DELETE      | Delete an existing task by ID ❌     | ✅             |
| `/update-task/{id}`| PUT         | Update an existing task by ID ✏️    | ✅             |

</div>

<!-- Authentication Endpoints Subsection -->
### 🔐 Authentication Endpoints

<div style="text-align:center" id="authentication-endpoints"> 

| Endpoint       | HTTP Method | Description                                 | Required Auth |
|----------------|-------------|---------------------------------------------|---------------|
| `/create-user` | POST        | Endpoint for creating (register) new user ➕ | ❌             |
| `/login`       | POST        | Endpoint for user login 👋                  | ❌             |
| `/me`          | POST        | Endpoint for retrieving user data 👤        | ✅             |
| `/log-out`     | POST        | Endpoint for user logout 🚪                 | ✅             |

</div>

 <!-- Contact section -->
## 📫 Contact

<div id="contact">

If you have any questions or suggestions, feel free to reach out:

- Email: [asgry255@gmail.com](mailto:asgry255@gmail.com)
- GitHub: [GitHub Page Link](https://github.com/AmiRM4A)

</div>

Happy coding! 🚀
