import 'dart:async';
import 'dart:convert';
import 'dart:io';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';

class ApiException implements Exception {
  final String message;
  final int statusCode;
  final Map<String, dynamic>? errors;

  ApiException(this.message, this.statusCode, [this.errors]);

  @override
  String toString() {
    if (errors != null && errors!.isNotEmpty) {
      List<String> errorMessages = [];
      for (var value in errors!.values) {
        if (value is List) {
          errorMessages.addAll(value.map((e) => e.toString()));
        } else {
          errorMessages.add(value.toString());
        }
      }
      if (errorMessages.isNotEmpty) {
        return errorMessages.join('\n');
      }
    }
    return message;
  }
}

class ApiClient {
  Future<Map<String, String>> _getHeaders() async {
    final prefs = await SharedPreferences.getInstance();
    final token = prefs.getString('auth_token');
    
    return {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      if (token != null) 'Authorization': 'Bearer $token',
    };
  }

  Future<dynamic> _processResponse(http.Response response) async {
    dynamic body;
    try {
      body = jsonDecode(response.body);
    } catch (e) {
      if (response.statusCode >= 500) {
        throw ApiException('Server unavailable. Please try again later.', response.statusCode);
      } else {
        throw ApiException('Something went wrong. Please try again.', response.statusCode);
      }
    }

    if (response.statusCode >= 200 && response.statusCode < 300) {
      if (body is Map && body['success'] == true) {
        return body['data'] ?? body;
      }
      // If it doesn't have success boolean or isn't a map but still 2xx, return the body
      return body;
    }

    // Handle standard API errors
    String message = (body is Map && body.containsKey('message')) 
        ? body['message'] 
        : 'Something went wrong. Please try again.';
    
    switch (response.statusCode) {
      case 400:
        message = 'Invalid request.';
        break;
      case 401:
        message = 'Please login again.';
        break;
      case 403:
        message = 'Permission denied.';
        break;
      case 404:
        message = 'Resource not found.';
        break;
      case 422:
        // Use Laravel's validation message
        break;
      case 429:
        message = 'Too many requests. Please try again later.';
        break;
      default:
        if (response.statusCode >= 500) {
          message = 'Server unavailable. Please try again later.';
        }
    }

    Map<String, dynamic>? errors;
    if (body is Map && body.containsKey('errors')) {
      errors = body['errors'];
    }

    throw ApiException(message, response.statusCode, errors);
  }

  void _handleException(Object e) {
    if (e is SocketException) {
      throw ApiException('No internet connection.', 0);
    } else if (e is TimeoutException) {
      throw ApiException('Connection timed out. Please try again.', 408);
    } else if (e is FormatException) {
      throw ApiException('Something went wrong. Please try again.', 0);
    } else if (e is ApiException) {
      throw e;
    } else {
      throw ApiException('Something went wrong. Please try again.', 0);
    }
  }

  Future<dynamic> get(String url) async {
    try {
      final headers = await _getHeaders();
      final response = await http.get(Uri.parse(url), headers: headers).timeout(const Duration(seconds: 15));
      return await _processResponse(response);
    } catch (e) {
      _handleException(e);
    }
  }

  Future<dynamic> post(String url, {Map<String, dynamic>? body}) async {
    try {
      final headers = await _getHeaders();
      final response = await http.post(
        Uri.parse(url),
        headers: headers,
        body: body != null ? jsonEncode(body) : null,
      ).timeout(const Duration(seconds: 15));
      return await _processResponse(response);
    } catch (e) {
      _handleException(e);
    }
  }

  Future<dynamic> put(String url, {Map<String, dynamic>? body}) async {
    try {
      final headers = await _getHeaders();
      final response = await http.put(
        Uri.parse(url),
        headers: headers,
        body: body != null ? jsonEncode(body) : null,
      ).timeout(const Duration(seconds: 15));
      return await _processResponse(response);
    } catch (e) {
      _handleException(e);
    }
  }

  Future<dynamic> delete(String url) async {
    try {
      final headers = await _getHeaders();
      final response = await http.delete(Uri.parse(url), headers: headers).timeout(const Duration(seconds: 15));
      return await _processResponse(response);
    } catch (e) {
      _handleException(e);
    }
  }
}
