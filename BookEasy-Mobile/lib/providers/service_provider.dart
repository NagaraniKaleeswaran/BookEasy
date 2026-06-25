import 'package:flutter/material.dart';
import '../config/api_config.dart';
import '../services/api_client.dart';
import '../models/service_model.dart';

class ServiceProvider with ChangeNotifier {
  final ApiClient _apiClient = ApiClient();
  List<ServiceModel> _services = [];
  bool _isLoading = false;
  String? _error;

  List<ServiceModel> get services => _services;
  bool get isLoading => _isLoading;
  String? get error => _error;

  Future<void> fetchServices() async {
    _isLoading = true;
    _error = null;
    notifyListeners();

    try {
      final response = await _apiClient.get(ApiConfig.services);
      final List<dynamic> data = response;
      _services = data.map((json) => ServiceModel.fromJson(json)).toList();
    } catch (e) {
      _error = e.toString();
    } finally {
      _isLoading = false;
      notifyListeners();
    }
  }
}
