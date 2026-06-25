import 'service_model.dart';

class AppointmentModel {
  final int id;
  final ServiceModel? service;
  final String customerName;
  final String customerEmail;
  final String customerPhone;
  final String appointmentDate;
  final String appointmentTime;
  final String status;
  final String? notes;

  AppointmentModel({
    required this.id,
    this.service,
    required this.customerName,
    required this.customerEmail,
    required this.customerPhone,
    required this.appointmentDate,
    required this.appointmentTime,
    required this.status,
    this.notes,
  });

  factory AppointmentModel.fromJson(Map<String, dynamic> json) {
    return AppointmentModel(
      id: json['id'],
      service: json['service'] != null ? ServiceModel.fromJson(json['service']) : null,
      customerName: json['customer_name'] ?? '',
      customerEmail: json['customer_email'] ?? '',
      customerPhone: json['customer_phone'] ?? '',
      appointmentDate: json['appointment_date'] ?? '',
      appointmentTime: json['appointment_time'] ?? '',
      status: json['status'] ?? 'pending',
      notes: json['notes'],
    );
  }
}
