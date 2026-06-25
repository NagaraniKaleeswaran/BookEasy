import 'package:flutter/material.dart';
import '../config/api_config.dart';
import '../services/api_client.dart';
import '../models/appointment_model.dart';

class AppointmentProvider with ChangeNotifier {
  final ApiClient _apiClient = ApiClient();
  
  List<AppointmentModel> _history = [];
  bool _isLoadingHistory = false;
  String? _historyError;

  List<String> _availableSlots = [];
  bool _isLoadingSlots = false;
  String? _slotsError;

  Map<String, dynamic>? _dashboardStats;
  bool _isLoadingStats = false;

  List<AppointmentModel> get history => _history;
  bool get isLoadingHistory => _isLoadingHistory;
  String? get historyError => _historyError;

  List<String> get availableSlots => _availableSlots;
  bool get isLoadingSlots => _isLoadingSlots;
  String? get slotsError => _slotsError;

  Map<String, dynamic>? get dashboardStats => _dashboardStats;
  bool get isLoadingStats => _isLoadingStats;

  Future<void> fetchHistory() async {
    _isLoadingHistory = true;
    _historyError = null;
    notifyListeners();

    try {
      final response = await _apiClient.get(ApiConfig.appointmentHistory);
      final List<dynamic> data = response;
      _history = data.map((json) => AppointmentModel.fromJson(json)).toList();
    } catch (e) {
      _historyError = e.toString();
    } finally {
      _isLoadingHistory = false;
      notifyListeners();
    }
  }

  Future<void> fetchAvailableSlots(int serviceId, String date) async {
    _isLoadingSlots = true;
    _slotsError = null;
    _availableSlots = [];
    notifyListeners();

    try {
      final response = await _apiClient.get('${ApiConfig.availableSlots}?service_id=$serviceId&date=$date');
      final List<dynamic> data = response;
      _availableSlots = data.cast<String>();
    } catch (e) {
      _slotsError = e.toString();
    } finally {
      _isLoadingSlots = false;
      notifyListeners();
    }
  }

  Future<AppointmentModel> bookAppointment(Map<String, dynamic> data) async {
    final response = await _apiClient.post(ApiConfig.appointments, body: data);
    return AppointmentModel.fromJson(response);
  }

  Future<void> fetchDashboardStats() async {
    _isLoadingStats = true;
    notifyListeners();

    try {
      final response = await _apiClient.get(ApiConfig.dashboardStats);
      _dashboardStats = response;
    } catch (e) {
      // Handle silently for dashboard
    } finally {
      _isLoadingStats = false;
      notifyListeners();
    }
  }
}
