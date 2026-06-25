import 'package:flutter_dotenv/flutter_dotenv.dart';

class ApiConfig {
  static String get baseUrl => dotenv.env['API_BASE_URL'] ?? 'https://bookeasy.esikalee.com/api';

  // Auth
  static String get login => '$baseUrl/login';
  static String get register => '$baseUrl/register';
  static String get logout => '$baseUrl/logout';

  // Business Modules
  static String get services => '$baseUrl/services';
  static String get appointments => '$baseUrl/appointments';
  static String get availableSlots => '$baseUrl/available-slots';
  
  // Customer & Dashboard
  static String get profile => '$baseUrl/profile';
  static String get appointmentHistory => '$baseUrl/appointment-history';
  static String get dashboardStats => '$baseUrl/dashboard/stats';
}
