import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../providers/service_provider.dart';
import 'booking/booking_date_time_screen.dart';

class ServicesScreen extends StatefulWidget {
  final bool isSelectionMode;
  const ServicesScreen({super.key, this.isSelectionMode = false});

  @override
  State<ServicesScreen> createState() => _ServicesScreenState();
}

class _ServicesScreenState extends State<ServicesScreen> {
  @override
  void initState() {
    super.initState();
    WidgetsBinding.instance.addPostFrameCallback((_) {
      Provider.of<ServiceProvider>(context, listen: false).fetchServices();
    });
  }

  @override
  Widget build(BuildContext context) {
    final spProvider = context.watch<ServiceProvider>();

    return Scaffold(
      appBar: AppBar(title: const Text('Services')),
      body: spProvider.isLoading
          ? const Center(child: CircularProgressIndicator())
          : spProvider.error != null
              ? Center(child: Text(spProvider.error!, style: const TextStyle(color: Colors.red)))
              : spProvider.services.isEmpty
                  ? const Center(child: Text('No services available at the moment.'))
                  : RefreshIndicator(
                      onRefresh: () => spProvider.fetchServices(),
                      child: ListView.builder(
                        padding: const EdgeInsets.all(16),
                        itemCount: spProvider.services.length,
                        itemBuilder: (context, index) {
                          final service = spProvider.services[index];
                          return Card(
                            margin: const EdgeInsets.only(bottom: 16),
                            child: ListTile(
                              contentPadding: const EdgeInsets.all(16),
                              title: Text(service.name, style: const TextStyle(fontSize: 18, fontWeight: FontWeight.bold)),
                              subtitle: Column(
                                crossAxisAlignment: CrossAxisAlignment.start,
                                children: [
                                  const SizedBox(height: 8),
                                  if (service.description != null) Text(service.description!),
                                  const SizedBox(height: 8),
                                  Row(
                                    children: [
                                      const Icon(Icons.timer, size: 16, color: Colors.grey),
                                      const SizedBox(width: 4),
                                      Text('${service.duration} mins'),
                                      const SizedBox(width: 16),
                                      const Icon(Icons.attach_money, size: 16, color: Colors.grey),
                                      const SizedBox(width: 4),
                                      Text(service.price),
                                    ],
                                  ),
                                ],
                              ),
                              trailing: ElevatedButton(
                                onPressed: () {
                                  Navigator.push(context, MaterialPageRoute(builder: (_) => BookingDateTimeScreen(service: service)));
                                },
                                child: const Text('Book'),
                              ),
                            ),
                          );
                        },
                      ),
                    ),
    );
  }
}
