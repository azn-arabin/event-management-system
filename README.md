
# 🗓 Event Management System

A simple **Event Management System** built with **Raw PHP** and **Bootstrap**, using **XAMPP** as a local server.  
This system allows users to **create, edit, delete, and register for events**, with an admin panel for event management.  

---

## 📌 Features
✔ User authentication (Register/Login/Logout)  
✔ Create, edit, and delete events (Only event creators can edit/delete)  
✔ Register for events (Prevents over-registration)  
✔ Display upcoming events with pagination, filtering, and sorting  
✔ Event details page with list of registered users  
✔ Bootstrap-based responsive UI  

---

## ⚙️ **Project Folder Structure**
```
event-management-system/
│── config/
│   ├── db.php                  # Database connection
│── public/
│   ├── css/                    # Bootstrap stylesheets
│   ├── js/                      # JavaScript files
│── views/
│   ├── layout/                  # Header/Footer templates
│   ├── index.php                # Homepage - Event list
│   ├── login.php                # User login form
│   ├── register.php             # User registration form
│   ├── dashboard.php            # User dashboard (view events)
│   ├── create_event.php         # Form to create an event
│   ├── edit_event.php           # Form to edit an event
│   ├── event_details.php        # Event details page with attendee list
│   ├── events_report.php        # Admin event report page
│── controllers/
│   ├── AuthController.php       # Handles login & registration
│   ├── EventController.php      # Handles CRUD for events
│   ├── AttendeeController.php   # Handles event registration
│── models/
│   ├── User.php                 # User model (DB operations)
│   ├── Event.php                # Event model (DB operations)
│   ├── Attendee.php             # Attendee model (DB operations)
│── routes.php                    # Handles URL routing
│── index.php                     # Entry point to include routes
│── README.md                     # Setup instructions
│── .htaccess                      # URL rewriting (for clean URLs)
```

---

## 🚀 **Setup Instructions**
Follow these steps to set up the project using **XAMPP**:

### 1️⃣ **Install XAMPP**
Download and install [XAMPP](https://www.apachefriends.org/index.html).  
Make sure **Apache** and **MySQL** are running in the XAMPP Control Panel.

### 2️⃣ **Clone the Repository**
```sh
git clone https://github.com/azn-arabin/event-management-system.git
cd event-management-system
```

### 3️⃣ **Move Project to XAMPP htdocs**
Move the `event-management-system/` folder to:
```
C:\xampp\htdocs\event-management-system\
```

### 4️⃣ **Create a MySQL Database**
1. Open **phpMyAdmin** (`http://localhost/phpmyadmin/`).
2. Create a **new database** called `event_management`.
3. Run the following **SQL script** to create the required tables:

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    date DATE NOT NULL,
    time TIME NOT NULL,
    location VARCHAR(255) NOT NULL,
    max_capacity INT NOT NULL CHECK (max_capacity > 0),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE attendees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    user_id INT NOT NULL,
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE(event_id, user_id) -- Prevents duplicate registrations
);
```

---

### 5️⃣ **Configure Database Connection**
create a **`.env`** file and insert the required variables:
```php
DB_HOST=localhost
DB_NAME=event_management
DB_USER=root
DB_PASS=

```

---

### 6️⃣ **Run the Project**
1. Start **Apache** and **MySQL** from XAMPP Control Panel.
2. Open your browser and go to:
```
http://localhost/event-management-system/
```

---

## 🛠 **Usage Guide**

### **🔹 User Authentication**
- **Register:** `/register`
- **Login:** `/login`
- **Logout:** `/logout`

### **🔹 Events**
- **View All Events:** `/`
- **Create an Event:** `/create-event`
- **Edit an Event:** `/edit-event?id=EVENT_ID`
- **Delete an Event:** `/delete-event?id=EVENT_ID`
- **Event Details (Attendee List & Registration):** `/event-details?id=EVENT_ID`

### **🔹 Attendee Registration**
- **Register for an Event:** `/attendee-register?event_id=EVENT_ID`

---

## 🎨 **Built With**
✔ **Raw PHP** (No frameworks, MVC structure)  
✔ **MySQL** (Database)  
✔ **Bootstrap** (For styling & responsiveness)  
✔ **XAMPP** (For local development)

---

## 📜 **License**
This project is open-source and free to use.

---

### 🎯 **Now, you’re ready to manage your events! 🚀**


