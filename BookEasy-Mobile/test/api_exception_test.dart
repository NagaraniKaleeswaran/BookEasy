import 'package:flutter_test/flutter_test.dart';
import 'package:bookeasy/services/api_client.dart';

void main() {
  test('ApiException parses Laravel validation errors correctly', () {
    final Map<String, dynamic> laravelResponse = {
      "success": false,
      "message": "Validation Error.",
      "errors": {
        "email": [
          "The email has already been taken."
        ],
        "password": [
          "The password confirmation does not match.",
          "The password field is required."
        ]
      }
    };

    final exception = ApiException(
      laravelResponse['message'],
      422,
      laravelResponse['errors'],
    );

    final result = exception.toString();
    print('--- Exception String ---');
    print(result);

    expect(result, contains('The email has already been taken.'));
    expect(result, contains('The password confirmation does not match.'));
    expect(result, contains('The password field is required.'));
  });
}
