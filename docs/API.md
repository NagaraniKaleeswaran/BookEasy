# BookEasy REST API Documentation

This document describes the REST API endpoints available for the BookEasy mobile application. The API returns standardized JSON responses and uses Laravel Sanctum for authentication.

## Authentication Flow
The API uses Bearer tokens for authentication via Laravel Sanctum.
1. Call `POST /api/login` or `POST /api/register` to receive an access token.
2. Include the token in the `Authorization` header of all protected requests:
   `Authorization: Bearer {token}`

## Standard Response Formats

**Success Response**
```json
{
  "success": true,
  "message": "Action performed successfully.",
  "data": {
    "key": "value"
  }
}
```

**Error Response**
```json
{
  "success": false,
  "message": "Validation Error.",
  "errors": {
    "field_name": ["Error message details."]
  }
}
```

---

## Public Endpoints

### 1. Register User
- **Endpoint**: `POST /api/register`
- **Description**: Registers a new customer and returns an auth token.
- **Request Body**:
```json
{
  "name": "Jane Doe",
  "email": "jane@example.com",
  "phone": "555-1234",
  "password": "password123",
  "password_confirmation": "password123"
}
```

### 2. Login User
- **Endpoint**: `POST /api/login`
- **Description**: Authenticates a user and returns an auth token.
- **Request Body**:
```json
{
  "email": "jane@example.com",
  "password": "password123"
}
```

### 3. Send Contact Message
- **Endpoint**: `POST /api/contact`
- **Description**: Submits a contact form message.
- **Request Body**:
```json
{
  "name": "Jane Doe",
  "email": "jane@example.com",
  "phone": "555-1234",
  "subject": "Question about services",
  "message": "Can I book a consultation online?"
}
```

---

## Protected Endpoints (Requires Bearer Token)

### 4. Logout User
- **Endpoint**: `POST /api/logout`
- **Description**: Revokes the user's current access token.

### 5. Get User Profile
- **Endpoint**: `GET /api/profile`
- **Description**: Retrieves the authenticated user's details.

### 6. Get Appointment History
- **Endpoint**: `GET /api/appointment-history`
- **Description**: Retrieves all past and upcoming appointments for the authenticated user.

### 7. Get Services
- **Endpoint**: `GET /api/services`
- **Description**: Lists all active services available for booking.

### 8. Get Available Time Slots
- **Endpoint**: `GET /api/available-slots`
- **Description**: Retrieves available 30-minute booking slots for a specific date and service.
- **Query Parameters**:
  - `date`: YYYY-MM-DD
  - `service_id`: ID of the service
- **Example**: `GET /api/available-slots?date=2026-06-25&service_id=1`

### 9. Create Appointment
- **Endpoint**: `POST /api/appointments`
- **Description**: Books a new appointment. Ownership (`user_id`) is inferred from the authenticated token.
- **Request Body**:
```json
{
  "service_id": 1,
  "appointment_date": "2026-06-25",
  "appointment_time": "14:30",
  "customer_name": "Jane Doe",
  "customer_email": "jane@example.com",
  "customer_phone": "555-1234",
  "notes": "Looking forward to it."
}
```

### 10. Update Appointment
- **Endpoint**: `PUT /api/appointments/{id}`
- **Description**: Updates an existing appointment belonging to the authenticated user.
- **Request Body**: (Same fields as POST, but all are optional).

### 11. Get Single Appointment
- **Endpoint**: `GET /api/appointments/{id}`
- **Description**: Retrieves details for a specific appointment belonging to the authenticated user.

### 12. Delete/Cancel Appointment
- **Endpoint**: `DELETE /api/appointments/{id}`
- **Description**: Cancels and removes an appointment belonging to the authenticated user.

### 13. Get Dashboard Statistics
- **Endpoint**: `GET /api/dashboard/stats`
- **Description**: Retrieves high-level dashboard metrics for the authenticated user (e.g., total/upcoming bookings).

### 14. Get Contact Messages
- **Endpoint**: `GET /api/contact-messages`
- **Description**: Lists all contact messages submitted to the platform.
