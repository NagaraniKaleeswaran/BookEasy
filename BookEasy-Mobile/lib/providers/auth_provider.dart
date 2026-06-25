import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';
import '../config/api_config.dart';
import '../services/api_client.dart';
import '../models/user_model.dart';

class AuthProvider with ChangeNotifier {
  final ApiClient _apiClient = ApiClient();
  UserModel? _user;
  bool _isLoading = false;
  bool _isAuthenticated = false;

  UserModel? get user => _user;
  bool get isLoading => _isLoading;
  bool get isAuthenticated => _isAuthenticated;

  Future<void> checkAuthStatus() async {
    final prefs = await SharedPreferences.getInstance();
    final token = prefs.getString('auth_token');
    
    if (token != null) {
      try {
        await fetchProfile();
      } catch (e) {
        await logout();
      }
    } else {
      _isAuthenticated = false;
      notifyListeners();
    }
  }

  Future<void> login(String email, String password) async {
    _isLoading = true;
    notifyListeners();

    try {
      final response = await _apiClient.post(ApiConfig.login, body: {
        'email': email,
        'password': password,
      });

      final prefs = await SharedPreferences.getInstance();
      await prefs.setString('auth_token', response['token']);
      
      _user = UserModel.fromJson(response['user']);
      _isAuthenticated = true;
    } finally {
      _isLoading = false;
      notifyListeners();
    }
  }

  Future<void> register(String name, String email, String phone, String password) async {
    _isLoading = true;
    notifyListeners();

    try {
      final response = await _apiClient.post(ApiConfig.register, body: {
        'name': name,
        'email': email,
        'phone': phone,
        'password': password,
        'password_confirmation': password,
      });

      final prefs = await SharedPreferences.getInstance();
      await prefs.setString('auth_token', response['token']);
      
      _user = UserModel.fromJson(response['user']);
      _isAuthenticated = true;
    } finally {
      _isLoading = false;
      notifyListeners();
    }
  }

  Future<void> fetchProfile() async {
    final response = await _apiClient.get(ApiConfig.profile);
    _user = UserModel.fromJson(response);
    _isAuthenticated = true;
    notifyListeners();
  }

  Future<void> logout() async {
    try {
      await _apiClient.post(ApiConfig.logout);
    } catch (e) {
      // Ignore errors on logout
    }

    final prefs = await SharedPreferences.getInstance();
    await prefs.remove('auth_token');
    
    _user = null;
    _isAuthenticated = false;
    notifyListeners();
  }
}
