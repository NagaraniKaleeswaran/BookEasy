# BookEasy: Project Portfolio Case Study

## 1. Business Problem
Local service businesses (salons, clinics, consulting) often rely on manual booking systems, leading to double-booked staff, lost revenue, and poor customer experiences. They lack an integrated platform that handles both internal administration and external customer mobile booking.

## 2. Solution
BookEasy is a two-part platform designed to solve this:
1. **The Laravel Admin Panel**: A secure, internal dashboard where business owners can define service offerings, map staff working hours, and review operational statistics.
2. **The Flutter Mobile App**: A native application for end-users to view active services, interact with real-time available time slots, and manage their own appointment profiles.

## 3. Architecture Overview
- **Backend**: Laravel 11 running on PHP 8.2.
- **Database**: MySQL strictly relational schema.
- **Web Frontend**: Laravel Blade tightly coupled with TailwindCSS.
- **Mobile Client**: Flutter application communicating via REST HTTP.

## 4. Database Design
The schema uses strong relational constraints (`ON DELETE CASCADE`):
- `users`: Both Admin and End-Customers.
- `services`: Dynamic catalogs of offerings.
- `staff` & `staff_availabilities`: A many-to-one mapping defining when a staff member works on specific days of the week.
- `appointments`: The central transactional table joining users and services while snapshotting customer details (`customer_name`, `email`, `phone`) for historical immutability.
- *Portfolio Exclusives*: `contact_messages`, `activity_logs`, `appointment_reminders`.

## 5. API Design
Powered by **Laravel Sanctum**.
- Uses Bearer token authentication.
- Unified JSON response formats (`Api/BaseController`).
- Real-time time slot interval generation taking raw staff availability and subtracting active overlapping appointments natively in the controller.

## 6. Mobile Architecture
- Built with **Flutter** & Dart.
- **State Management**: Uses the `provider` package to reactively update the UI when network state changes.
- **API Interceptors**: A custom `ApiClient` wrapper that securely injects Sanctum tokens and gracefully catches internet dropouts and server 500 errors.

## 7. Technical Challenges Resolved
- **Concurrency Prevention**: Designing the Time Slot engine to natively map overlapping `start_time` and `end_time` logic across MySQL date boundaries.
- **Immutability**: Ensuring that if a customer updates their profile phone number, past bookings retain the *snapshot* of the phone number at the time of booking.
- **Cross-Environment Build Bugs**: Addressed Incremental Kotlin caching crashes when building the APK.

## 8. Future Enhancements
- Real-time WebSockets via Laravel Reverb to prevent race conditions.
- Integration of a payment gateway like Stripe.
- Active SMS/Email dispatches via Laravel Scheduler tapping into the `appointment_reminders` table.

---

## 📸 Screenshot Capture Checklist
Use this checklist to capture the necessary assets to finalize your portfolio.

### Website Pages
- [ ] Home Page Hero (`/`)
- [ ] Services Catalog (`/services`)
- [ ] Contact Form (`/contact`)

### Admin Dashboard (`/admin/dashboard`)
- [ ] Login Screen
- [ ] Main Dashboard with Charts
- [ ] Appointments List View
- [ ] Services Create/Edit View
- [ ] Staff Availability Matrix

### Flutter Mobile App
- [ ] Splash & Login Screen
- [ ] Home Screen / Dashboard
- [ ] Services Scrolling List
- [ ] Interactive Booking Flow (Date & Time Picker)
- [ ] Booking Success Screen
- [ ] Appointment History Log
