import 'package:flutter/material.dart';
import '../../models/appointment_model.dart';
import '../main_layout.dart';

class BookingSuccessScreen extends StatelessWidget {
  final AppointmentModel appointment;

  const BookingSuccessScreen({super.key, required this.appointment});

  Widget _buildSectionHeader(String title) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 8.0),
      child: Text(
        title,
        style: const TextStyle(
          fontSize: 18,
          fontWeight: FontWeight.bold,
          color: Colors.indigo,
        ),
      ),
    );
  }

  Widget _buildDetailRow(String label, String value) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 6.0),
      child: Row(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          SizedBox(
            width: 100,
            child: Text(
              label,
              style: const TextStyle(
                color: Colors.grey,
                fontWeight: FontWeight.w500,
              ),
            ),
          ),
          const Text(':  ', style: TextStyle(color: Colors.grey)),
          Expanded(
            child: Text(
              value,
              style: const TextStyle(
                fontWeight: FontWeight.w600,
                color: Colors.black87,
              ),
            ),
          ),
        ],
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    // Determine status color based on string
    Color statusColor = Colors.orange;
    if (appointment.status.toLowerCase() == 'confirmed') statusColor = Colors.green;
    if (appointment.status.toLowerCase() == 'completed') statusColor = Colors.blue;
    if (appointment.status.toLowerCase() == 'cancelled') statusColor = Colors.red;

    final serviceName = appointment.service?.name ?? 'Service information unavailable';
    final duration = appointment.service?.duration != null ? '${appointment.service!.duration} Minutes' : 'N/A';
    final price = appointment.service?.price != null ? '\$${appointment.service!.price}' : 'N/A';
    // Format time, just taking first 5 chars assuming HH:mm:ss format
    final formattedTime = appointment.appointmentTime.length >= 5 
        ? appointment.appointmentTime.substring(0, 5) 
        : appointment.appointmentTime;

    return Scaffold(
      backgroundColor: Colors.grey[50],
      body: SafeArea(
        child: SingleChildScrollView(
          padding: const EdgeInsets.all(24),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.center,
            children: [
              const SizedBox(height: 20),
              const Icon(Icons.check_circle, color: Colors.green, size: 80),
              const SizedBox(height: 16),
              const Text(
                'Booking Confirmed!',
                style: TextStyle(fontSize: 26, fontWeight: FontWeight.bold, color: Colors.black87),
              ),
              const SizedBox(height: 24),
              Card(
                elevation: 2,
                shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
                color: Colors.white,
                child: Padding(
                  padding: const EdgeInsets.all(20),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.stretch,
                    children: [
                      _buildSectionHeader('Booking Summary'),
                      _buildDetailRow('Booking ID', '#${appointment.id}'),
                      _buildDetailRow('Service', serviceName),
                      _buildDetailRow('Duration', duration),
                      _buildDetailRow('Price', price),
                      
                      const Divider(height: 24),
                      
                      _buildSectionHeader('Customer'),
                      _buildDetailRow('Name', appointment.customerName),
                      _buildDetailRow('Email', appointment.customerEmail),
                      if (appointment.customerPhone.isNotEmpty)
                        _buildDetailRow('Phone', appointment.customerPhone),

                      const Divider(height: 24),
                      
                      _buildSectionHeader('Appointment'),
                      _buildDetailRow('Date', appointment.appointmentDate),
                      _buildDetailRow('Time', formattedTime),
                      
                      const SizedBox(height: 12),
                      Row(
                        children: [
                          const SizedBox(width: 100, child: Text('Status', style: TextStyle(color: Colors.grey, fontWeight: FontWeight.w500))),
                          const Text(':  ', style: TextStyle(color: Colors.grey)),
                          Container(
                            padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                            decoration: BoxDecoration(
                              color: statusColor.withValues(alpha: 0.1),
                              borderRadius: BorderRadius.circular(6),
                            ),
                            child: Text(
                              appointment.status.toUpperCase(),
                              style: TextStyle(
                                color: statusColor,
                                fontWeight: FontWeight.bold,
                                fontSize: 13,
                              ),
                            ),
                          ),
                        ],
                      ),
                    ],
                  ),
                ),
              ),
              const SizedBox(height: 32),
              ElevatedButton(
                onPressed: () {
                  Navigator.pushAndRemoveUntil(
                    context,
                    MaterialPageRoute(builder: (_) => const MainLayout()),
                    (route) => false,
                  );
                },
                style: ElevatedButton.styleFrom(
                  minimumSize: const Size(double.infinity, 54),
                  backgroundColor: Colors.indigo,
                  foregroundColor: Colors.white,
                  shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8)),
                  elevation: 0,
                ),
                child: const Text('Back to Home', style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold)),
              ),
              const SizedBox(height: 20),
            ],
          ),
        ),
      ),
    );
  }
}
