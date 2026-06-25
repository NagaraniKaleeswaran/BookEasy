import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../providers/appointment_provider.dart';
import 'services_screen.dart';

class HomeScreen extends StatefulWidget {
  const HomeScreen({super.key});

  @override
  State<HomeScreen> createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> {
  @override
  void initState() {
    super.initState();
    WidgetsBinding.instance.addPostFrameCallback((_) {
      Provider.of<AppointmentProvider>(context, listen: false).fetchDashboardStats();
    });
  }

  @override
  Widget build(BuildContext context) {
    final apProvider = context.watch<AppointmentProvider>();
    final stats = apProvider.dashboardStats;

    return Scaffold(
      appBar: AppBar(title: const Text('BookEasy Dashboard')),
      body: apProvider.isLoadingStats
          ? const Center(child: CircularProgressIndicator())
          : RefreshIndicator(
              onRefresh: () => apProvider.fetchDashboardStats(),
              child: ListView(
                padding: const EdgeInsets.all(16),
                children: [
                  _buildStatCard('Total Bookings', stats?['total_bookings']?.toString() ?? '0', Icons.book, Colors.indigo),
                  const SizedBox(height: 16),
                  _buildStatCard('Upcoming Bookings', stats?['upcoming_bookings']?.toString() ?? '0', Icons.upcoming, Colors.blue),
                  const SizedBox(height: 32),
                  const Text('Ready to book an appointment?', style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold)),
                  const SizedBox(height: 16),
                  ElevatedButton.icon(
                    onPressed: () {
                      // We'll navigate via BottomNavBar, but for quick action we can push
                      Navigator.push(context, MaterialPageRoute(builder: (_) => const ServicesScreen(isSelectionMode: true)));
                    },
                    icon: const Icon(Icons.add),
                    label: const Text('Book Now', style: TextStyle(fontSize: 18)),
                    style: ElevatedButton.styleFrom(padding: const EdgeInsets.all(16)),
                  ),
                ],
              ),
            ),
    );
  }

  Widget _buildStatCard(String title, String value, IconData icon, Color color) {
    return Card(
      elevation: 2,
      child: Padding(
        padding: const EdgeInsets.all(24),
        child: Row(
          children: [
            CircleAvatar(backgroundColor: color.withValues(alpha: 0.1), radius: 30, child: Icon(icon, color: color, size: 30)),
            const SizedBox(width: 24),
            Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(title, style: const TextStyle(fontSize: 16, color: Colors.grey)),
                const SizedBox(height: 8),
                Text(value, style: const TextStyle(fontSize: 32, fontWeight: FontWeight.bold)),
              ],
            )
          ],
        ),
      ),
    );
  }
}
