import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../../models/service_model.dart';
import '../../providers/auth_provider.dart';
import '../../providers/appointment_provider.dart';
import 'booking_success_screen.dart';

class BookingDetailsScreen extends StatefulWidget {
  final ServiceModel service;
  final String date;
  final String time;

  const BookingDetailsScreen({
    super.key,
    required this.service,
    required this.date,
    required this.time,
  });

  @override
  State<BookingDetailsScreen> createState() => _BookingDetailsScreenState();
}

class _BookingDetailsScreenState extends State<BookingDetailsScreen> {
  final _nameCtrl = TextEditingController();
  final _emailCtrl = TextEditingController();
  final _phoneCtrl = TextEditingController();
  final _notesCtrl = TextEditingController();
  final _formKey = GlobalKey<FormState>();
  bool _isSubmitting = false;

  @override
  void initState() {
    super.initState();
    final user = Provider.of<AuthProvider>(context, listen: false).user;
    if (user != null) {
      _nameCtrl.text = user.name;
      _emailCtrl.text = user.email;
      _phoneCtrl.text = user.phone ?? '';
    }
  }

  Future<void> _submitBooking() async {
    if (!_formKey.currentState!.validate()) return;

    setState(() => _isSubmitting = true);
    
    try {
      final apProvider = Provider.of<AppointmentProvider>(context, listen: false);
      final appointment = await apProvider.bookAppointment({
        'service_id': widget.service.id,
        'appointment_date': widget.date,
        'appointment_time': widget.time,
        'customer_name': _nameCtrl.text,
        'customer_email': _emailCtrl.text,
        'customer_phone': _phoneCtrl.text,
        'notes': _notesCtrl.text,
      });

      if (!mounted) return;
      Navigator.pushAndRemoveUntil(
        context,
        MaterialPageRoute(builder: (_) => BookingSuccessScreen(appointment: appointment)),
        (route) => route.isFirst,
      );
    } catch (e) {
      if (!mounted) return;
      ScaffoldMessenger.of(context).showSnackBar(SnackBar(content: Text(e.toString()), backgroundColor: Colors.red));
    } finally {
      if (mounted) setState(() => _isSubmitting = false);
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Customer Details')),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(16),
        child: Form(
          key: _formKey,
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.stretch,
            children: [
              Card(
                child: Padding(
                  padding: const EdgeInsets.all(16),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text('Booking Summary', style: Theme.of(context).textTheme.titleLarge),
                      const SizedBox(height: 8),
                      Text('Service: ${widget.service.name}'),
                      Text('Date: ${widget.date}'),
                      Text('Time: ${widget.time.substring(0, 5)}'),
                      Text('Total: ${widget.service.price}', style: const TextStyle(fontWeight: FontWeight.bold)),
                    ],
                  ),
                ),
              ),
              const SizedBox(height: 24),
              TextFormField(
                controller: _nameCtrl,
                decoration: const InputDecoration(labelText: 'Full Name', border: OutlineInputBorder()),
                validator: (v) => v!.isEmpty ? 'Required' : null,
              ),
              const SizedBox(height: 16),
              TextFormField(
                controller: _emailCtrl,
                decoration: const InputDecoration(labelText: 'Email', border: OutlineInputBorder()),
                keyboardType: TextInputType.emailAddress,
                validator: (v) => v!.isEmpty ? 'Required' : null,
              ),
              const SizedBox(height: 16),
              TextFormField(
                controller: _phoneCtrl,
                decoration: const InputDecoration(labelText: 'Phone', border: OutlineInputBorder()),
                keyboardType: TextInputType.phone,
                validator: (v) => v!.isEmpty ? 'Required' : null,
              ),
              const SizedBox(height: 16),
              TextFormField(
                controller: _notesCtrl,
                decoration: const InputDecoration(labelText: 'Notes (Optional)', border: OutlineInputBorder()),
                maxLines: 3,
              ),
              const SizedBox(height: 24),
              ElevatedButton(
                onPressed: _isSubmitting ? null : _submitBooking,
                style: ElevatedButton.styleFrom(padding: const EdgeInsets.symmetric(vertical: 16)),
                child: _isSubmitting
                    ? const SizedBox(width: 20, height: 20, child: CircularProgressIndicator(strokeWidth: 2))
                    : const Text('Confirm Booking', style: TextStyle(fontSize: 16)),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
