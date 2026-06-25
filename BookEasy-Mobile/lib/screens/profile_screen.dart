import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../providers/auth_provider.dart';
import 'login_screen.dart';

class ProfileScreen extends StatelessWidget {
  const ProfileScreen({super.key});

  @override
  Widget build(BuildContext context) {
    final auth = context.watch<AuthProvider>();
    final user = auth.user;

    return Scaffold(
      appBar: AppBar(
        title: const Text('Profile'),
        actions: [
          IconButton(
            icon: const Icon(Icons.logout),
            onPressed: () async {
              await auth.logout();
              if (!context.mounted) return;
              Navigator.of(context).pushAndRemoveUntil(
                MaterialPageRoute(builder: (_) => const LoginScreen()),
                (route) => false,
              );
            },
          )
        ],
      ),
      body: user == null
          ? const Center(child: CircularProgressIndicator())
          : SingleChildScrollView(
              padding: const EdgeInsets.all(24),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.center,
                children: [
                  const CircleAvatar(
                    radius: 50,
                    child: Icon(Icons.person, size: 50),
                  ),
                  const SizedBox(height: 24),
                  Text(user.name, style: const TextStyle(fontSize: 24, fontWeight: FontWeight.bold)),
                  const SizedBox(height: 8),
                  Text(user.email, style: const TextStyle(fontSize: 16, color: Colors.grey)),
                  const SizedBox(height: 32),
                  const Divider(),
                  ListTile(
                    leading: const Icon(Icons.phone),
                    title: const Text('Phone Number'),
                    subtitle: Text(user.phone?.isNotEmpty == true ? user.phone! : 'Not provided'),
                  ),
                  const Divider(),
                  const ListTile(
                    leading: Icon(Icons.security),
                    title: Text('Account Role'),
                    subtitle: Text('Customer'),
                  ),
                  const Divider(),
                ],
              ),
            ),
    );
  }
}
