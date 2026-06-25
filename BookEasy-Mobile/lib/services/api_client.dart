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
    final body = jsonDecode(response.body);

    if (response.statusCode >= 200 && response.statusCode < 300) {
      if (body['success'] == true) {
        return body['data'] ?? body;
      }
    }

    // Handle standard API errors
    throw ApiException(
      body['message'] ?? 'An unknown error occurred',
      response.statusCode,
      body['errors'],
    );
  }

  Future<dynamic> get(String url) async {
    try {
      final headers = await _getHeaders();
      final response = await http.get(Uri.parse(url), headers: headers).timeout(const Duration(seconds: 15));
      return await _processResponse(response);
    } on SocketException {
      throw ApiException('No Internet Connection', 0);
    } on Exception catch (e) {
      if (e is ApiException) rethrow;
      throw ApiException('Connection Timeout', 408);
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
    } on SocketException {
      throw ApiException('No Internet Connection', 0);
    } on Exception catch (e) {
      if (e is ApiException) rethrow;
      throw ApiException('Connection Timeout', 408);
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
    } on SocketException {
      throw ApiException('No Internet Connection', 0);
    } on Exception catch (e) {
      if (e is ApiException) rethrow;
      throw ApiException('Connection Timeout', 408);
    }
  }

  Future<dynamic> delete(String url) async {
    try {
      final headers = await _getHeaders();
      final response = await http.delete(Uri.parse(url), headers: headers).timeout(const Duration(seconds: 15));
      return await _processResponse(response);
    } on SocketException {
      throw ApiException('No Internet Connection', 0);
    } on Exception catch (e) {
      if (e is ApiException) rethrow;
      throw ApiException('Connection Timeout', 408);
    }
  }
}
