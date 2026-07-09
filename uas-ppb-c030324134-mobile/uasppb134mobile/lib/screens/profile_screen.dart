import 'package:flutter/material.dart';
import '../config.dart';

class ProfileScreen extends StatelessWidget {
  const ProfileScreen({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text("Profil Saya", style: TextStyle(color: Colors.white, fontWeight: FontWeight.bold)),
        backgroundColor: const Color(0xFF1E293B),
        iconTheme: const IconThemeData(color: Colors.white),
      ),
      backgroundColor: const Color(0xFF0F172A),
      body: Center(
        child: Padding(
          padding: const EdgeInsets.all(24.0),
          child: Card(
            shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
            elevation: 6,
            child: Padding(
              padding: const EdgeInsets.all(24.0),
              child: Column(
                mainAxisSize: MainAxisSize.min,
                children: [
                  const Text(
                    "FOTO PROFILE",
                    style: TextStyle(fontWeight: FontWeight.bold, fontSize: 16, letterSpacing: 1.5),
                  ),
                  const SizedBox(height: 20),
                  Container(
                    width: 90,
                    height: 90,
                    decoration: BoxDecoration(
                      color: Colors.blueGrey.shade100,
                      shape: BoxShape.circle,
                    ),
                    child: const Center(
                      child: Text("👤", style: TextStyle(fontSize: 45)),
                    ),
                  ),
                  const SizedBox(height: 30),
                  Row(
                    children: [
                      const SizedBox(
                        width: 80,
                        child: Text("Nama", style: TextStyle(fontWeight: FontWeight.bold, color: Colors.grey)),
                      ),
                      Text(": ${AppConfig.userName}", style: const TextStyle(fontWeight: FontWeight.bold)),
                    ],
                  ),
                  const Divider(height: 24),
                  Row(
                    children: [
                      const SizedBox(
                        width: 80,
                        child: Text("Email", style: TextStyle(fontWeight: FontWeight.bold, color: Colors.grey)),
                      ),
                      Expanded(
                        child: Text(": ${AppConfig.userEmail}", style: const TextStyle(fontWeight: FontWeight.bold), overflow: TextOverflow.ellipsis),
                      ),
                    ],
                  ),
                  const Divider(height: 24),
                  Row(
                    children: [
                      const SizedBox(
                        width: 80,
                        child: Text("Role", style: TextStyle(fontWeight: FontWeight.bold, color: Colors.grey)),
                      ),
                      Text(
                        ": ${AppConfig.userRole.toUpperCase()}",
                        style: TextStyle(
                          fontWeight: FontWeight.bold,
                          color: AppConfig.userRole == 'admin' ? Colors.red : Colors.blue,
                        ),
                      ),
                    ],
                  ),
                ],
                  ),
                ),
              ),
            ),
          ),
    );
  }
}