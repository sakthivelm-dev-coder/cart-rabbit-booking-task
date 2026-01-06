# Calendly-Style Appointment Scheduler  
**Laravel (Backend) + React (Frontend)**

A mini appointment-scheduling application inspired by **Calendly**, built as a technical challenge using **Laravel (PHP)** for the backend and **React** for the frontend.

---

## 🚀 Features

### User Features
- View available dates and time slots
- Book an appointment by entering name and email
- Prevents double booking
- Friendly success and error responses

### Backend Features
- RESTful API built with Laravel
- Slot availability management
- Booking creation with conflict prevention
- SQL database persistence
- Clean MVC architecture

### Frontend Features
- React-based UI
- Fetches real-time availability from backend
- Simple, intuitive booking flow

---

## 🗂 Project Structure

```
.
├── backend/
│   ├── app/Http/Controllers/
│   ├── app/Models/
│   ├── routes/api.php
│   └── README.md
│
├── frontend/
│   ├── src/App.jsx
│   ├── src/main.jsx
│   └── README.md
│
└── README.md
```

---

## 🧠 Data Model Design

### Slot
- id
- start_time
- end_time
- is_booked

### Booking
- id
- slot_id (FK)
- name
- email

**Relationship**
- One Slot → One Booking
- Slot cannot be booked more than once

---

## 🔗 API Endpoints

### Get Available Slots
```
GET /api/slots
```

### Create Booking
```
POST /api/bookings
```

---

## ⚙️ Installation & Setup

### Backend (Laravel)
```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

Backend runs at:
```
http://localhost:8000
```

---

### Frontend (React)
```bash
cd frontend
npm install
npm run dev
```

Frontend runs at:
```
http://localhost:5173
```

---

## 🛠 Technologies Used

**Backend**
- PHP 8+
- Laravel
- MySQL / SQLite

**Frontend**
- React
- Vite
- JavaScript (ES6+)

---

## 🤖 AI Usage
AI tools were used for:
- Architecture planning
- Boilerplate acceleration
- Code quality improvements

---

## 📈 Future Improvements
- Admin availability management
- Email notifications
- Calendar UI component
- Mobile responsive layout

---

## 📄 License
For technical evaluation and demonstration purposes.
