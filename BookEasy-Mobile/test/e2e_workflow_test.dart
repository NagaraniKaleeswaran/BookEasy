import 'package:flutter_test/flutter_test.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:bookeasy/providers/auth_provider.dart';
import 'package:bookeasy/providers/service_provider.dart';
import 'package:bookeasy/providers/appointment_provider.dart';

import 'package:flutter_dotenv/flutter_dotenv.dart';

void main() {
  setUp(() async {
    dotenv.testLoad(fileInput: "API_BASE_URL=http://192.168.1.2:8000/api");
    SharedPreferences.setMockInitialValues({});
  });

  test('End-to-End User Workflow Test', () async {
    final authProvider = AuthProvider();
    final serviceProvider = ServiceProvider();
    final appointmentProvider = AppointmentProvider();

    print('--- 1. Register User ---');
    await authProvider.register(
      'Flutter E2E User',
      'fluttere2e@example.com',
      '1234567890',
      'password123',
    );
    expect(authProvider.isAuthenticated, isTrue);
    expect(authProvider.user, isNotNull);
    print('User registered successfully.');

    print('\n--- 2. Logout User ---');
    await authProvider.logout();
    expect(authProvider.isAuthenticated, isFalse);
    expect(authProvider.user, isNull);
    print('User logged out successfully.');

    print('\n--- 3. Login User ---');
    await authProvider.login('fluttere2e@example.com', 'password123');
    expect(authProvider.isAuthenticated, isTrue);
    expect(authProvider.user, isNotNull);
    print('User logged in successfully.');

    print('\n--- 4. Verify Auto Login ---');
    final authProvider2 = AuthProvider();
    await authProvider2.checkAuthStatus();
    expect(authProvider2.isAuthenticated, isTrue);
    expect(authProvider2.user?.email, 'fluttere2e@example.com');
    print('Auto-login successful.');

    print('\n--- 5. Fetch Services ---');
    await serviceProvider.fetchServices();
    expect(serviceProvider.services.isNotEmpty, isTrue);
    print('Fetched ${serviceProvider.services.length} services.');

    final serviceId = serviceProvider.services.first.id;
    final date = DateTime.now().add(const Duration(days: 2)).toIso8601String().split('T')[0];

    print('\n--- 6. Fetch Available Slots ---');
    await appointmentProvider.fetchAvailableSlots(serviceId, date);
    expect(appointmentProvider.availableSlots.isNotEmpty, isTrue);
    print('Fetched ${appointmentProvider.availableSlots.length} available slots.');

    final timeStr = appointmentProvider.availableSlots.first;

    print('\n--- 7. Create Appointment ---');
    final appointment = await appointmentProvider.bookAppointment({
      'service_id': serviceId,
      'appointment_date': date,
      'appointment_time': timeStr,
      'customer_name': 'Flutter E2E User',
      'customer_email': 'fluttere2e@example.com',
      'customer_phone': '1234567890',
      'notes': 'Booked from Flutter Test'
    });
    expect(appointment.id, isNotNull);
    print('Appointment created with ID: ${appointment.id}');

    print('\n--- 8. View Appointment History ---');
    await appointmentProvider.fetchHistory();
    expect(appointmentProvider.history.isNotEmpty, isTrue);
    print('History contains ${appointmentProvider.history.length} appointments.');

    print('\n--- 9. View Profile ---');
    await authProvider.fetchProfile();
    expect(authProvider.user?.email, 'fluttere2e@example.com');
    print('Profile verified.');

    print('\n--- 10. Verify Token Removal (Logout) ---');
    await authProvider.logout();
    expect(authProvider.isAuthenticated, isFalse);
    final prefs = await SharedPreferences.getInstance();
    expect(prefs.getString('auth_token'), isNull);
    print('Token successfully removed and logged out.');
  });
}
