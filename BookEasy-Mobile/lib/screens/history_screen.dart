import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../providers/appointment_provider.dart';

class HistoryScreen extends StatefulWidget {
  const HistoryScreen({super.key});

  @override
  State<HistoryScreen> createState() => _HistoryScreenState();
}

class _HistoryScreenState extends State<HistoryScreen> {
  @override
  void initState() {
    super.initState();
    WidgetsBinding.instance.addPostFrameCallback((_) {
      Provider.of<AppointmentProvider>(context, listen: false).fetchHistory();
    });
  }

  Color _getStatusColor(String status) {
    switch (status.toLowerCase()) {
      case 'pending': return Colors.orange;
      case 'confirmed': return Colors.green;
      case 'completed': return Colors.blue;
      case 'cancelled': return Colors.red;
      default: return Colors.grey;
    }
  }

  @override
  Widget build(BuildContext context) {
    final apProvider = context.watch<AppointmentProvider>();

    return Scaffold(
      appBar: AppBar(title: const Text('Appointment History')),
      body: apProvider.isLoadingHistory
          ? const Center(child: CircularProgressIndicator())
          : apProvider.historyError != null
              ? Center(child: Text(apProvider.historyError!, style: const TextStyle(color: Colors.red)))
              : apProvider.history.isEmpty
                  ? const Center(child: Text('No appointments found.'))
                  : RefreshIndicator(
                      onRefresh: () => apProvider.fetchHistory(),
                      child: ListView.builder(
                        padding: const EdgeInsets.all(16),
                        itemCount: apProvider.history.length,
                        itemBuilder: (context, index) {
                          final apt = apProvider.history[index];
                          return Card(
                            margin: const EdgeInsets.only(bottom: 16),
                            child: Padding(
                              padding: const EdgeInsets.all(16),
                              child: Column(
                                crossAxisAlignment: CrossAxisAlignment.start,
                                children: [
                                  Row(
                                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                    children: [
                                      Text('#${apt.id}', style: const TextStyle(fontWeight: FontWeight.bold, color: Colors.grey)),
                                      Container(
                                        padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
                                        decoration: BoxDecoration(
                                          color: _getStatusColor(apt.status).withValues(alpha: 0.1),
                                          borderRadius: BorderRadius.circular(4),
                                        ),
                                        child: Text(
                                          apt.status.toUpperCase(),
                                          style: TextStyle(color: _getStatusColor(apt.status), fontSize: 12, fontWeight: FontWeight.bold),
                                        ),
                                      ),
                                    ],
                                  ),
                                  const SizedBox(height: 12),
                                  Text(apt.service?.name ?? 'Unknown Service', style: const TextStyle(fontSize: 18, fontWeight: FontWeight.bold)),
                                  const SizedBox(height: 8),
                                  Row(
                                    children: [
                                      const Icon(Icons.calendar_today, size: 16, color: Colors.grey),
                                      const SizedBox(width: 8),
                                      Text(apt.appointmentDate),
                                      const SizedBox(width: 16),
                                      const Icon(Icons.access_time, size: 16, color: Colors.grey),
                                      const SizedBox(width: 8),
                                      Text(apt.appointmentTime.substring(0, 5)),
                                    ],
                                  ),
                                ],
                              ),
                            ),
                          );
                        },
                      ),
                    ),
    );
  }
}
