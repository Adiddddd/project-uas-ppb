import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import '../../config.dart';
import 'login_screen.dart';
import 'profile_screen.dart';
import 'form_gudang_screen.dart';

class DashboardScreen extends StatefulWidget {
  const DashboardScreen({Key? key}) : super(key: key);

  @override
  _DashboardScreenState createState() => _DashboardScreenState();
}

class _DashboardScreenState extends State<DashboardScreen> {
  List<dynamic> _gudangList = [];
  bool _isLoading = true;

  @override
  void initState() {
    super.initState();
    _fetchGudangData();
  }

  Future<void> _fetchGudangData() async {
    setState(() => _isLoading = true);
    try {
      final response = await http.get(
        Uri.parse("${AppConfig.baseUrl}/gudang"),
        headers: {
          "Authorization": "Bearer ${AppConfig.token}",
          "Accept": "application/json"
        },
      );
      if (response.statusCode == 200) {
        final jsonResponse = jsonDecode(response.body);
        setState(() {
          _gudangList = jsonResponse['data'];
        });
      }
    } catch (e) {
      _showSnackBar("Gagal mengambil data dari server.");
    } finally {
      setState(() => _isLoading = false);
    }
  }

  void _deleteGudang(int id, int index) async {
    try {
      final response = await http.delete(
        Uri.parse("${AppConfig.baseUrl}/gudang/$id"),
        headers: {
          "Authorization": "Bearer ${AppConfig.token}",
          "Accept": "application/json"
        },
      );
      if (response.statusCode == 200) {
        setState(() {
          _gudangList.removeAt(index);
        });
        _showSnackBar("Data gudang berhasil dihapus.");
      } else {
        _fetchGudangData(); 
        _showSnackBar("Gagal menghapus data di server.");
      }
    } catch (e) {
      _fetchGudangData();
      _showSnackBar("Terjadi kesalahan koneksi.");
    }
  }

  void _showSnackBar(String message) {
    ScaffoldMessenger.of(context).showSnackBar(SnackBar(content: Text(message)));
  }

  @override
  Widget build(BuildContext context) {
    bool isAdmin = AppConfig.userRole == 'admin';

    return Scaffold(
      appBar: AppBar(
        title: const Text("Dashboard Gudang", style: TextStyle(color: Colors.white, fontWeight: FontWeight.bold)),
        backgroundColor: const Color(0xFF1E293B),
        iconTheme: const IconThemeData(color: Colors.white),
      ),
      
      // ================= SIDEBAR (DRAWER) BERDASARKAN ROLE =================
      drawer: Drawer(
        child: Container(
          color: const Color(0xFF0F172A), 
          child: ListView(
            padding: EdgeInsets.zero,
            children: [
              UserAccountsDrawerHeader(
                decoration: const BoxDecoration(color: Color(0xFF1E293B)),
                accountName: Text(AppConfig.userName, style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 16)),
                accountEmail: Text("Role: ${AppConfig.userRole.toUpperCase()}", style: const TextStyle(color: Colors.blueGrey)),
                currentAccountPicture: const CircleAvatar(
                  backgroundColor: Colors.blue,
                  child: Text("👤", style: TextStyle(fontSize: 30)),
                ),
              ),
              ListTile(
                leading: const Icon(Icons.dashboard, color: Colors.white),
                title: const Text("Dashboard", style: TextStyle(color: Colors.white)),
                onTap: () => Navigator.pop(context),
              ),
              
              if (isAdmin)
                ListTile(
                  leading: const Icon(Icons.add_box, color: Colors.white),
                  title: const Text("Membuat Gudang", style: TextStyle(color: Colors.white)),
                  onTap: () {
                    Navigator.pop(context);
                    Navigator.push(
                      context,
                      MaterialPageRoute(builder: (context) => const FormGudangScreen()),
                    ).then((_) => _fetchGudangData());
                  },
                ),
              
              ListTile(
                leading: const Icon(Icons.person, color: Colors.white),
                title: const Text("Profil", style: TextStyle(color: Colors.white)),
                onTap: () {
                  Navigator.pop(context);
                  Navigator.push(context, MaterialPageRoute(builder: (context) => const ProfileScreen()));
                },
              ),
              const Divider(color: Colors.blueGrey),
              ListTile(
                leading: const Icon(Icons.logout, color: Colors.redAccent),
                title: const Text("Logout", style: TextStyle(color: Colors.redAccent, fontWeight: FontWeight.bold)),
                onTap: () {
                  AppConfig.token = "";
                  AppConfig.userRole = "";
                  Navigator.pushReplacement(context, MaterialPageRoute(builder: (context) => const LoginScreen()));
                },
              ),
            ],
          ),
        ),
      ),

      // ================= LIST DATA GUDANG DENGAN SWIPE TO DELETE =================
      body: _isLoading
          ? const Center(child: CircularProgressIndicator())
          : _gudangList.isEmpty
              ? const Center(child: Text("Belum ada data gudang.", style: TextStyle(fontSize: 16, color: Colors.grey)))
              : ListView.builder(
                  itemCount: _gudangList.length,
                  itemBuilder: (context, index) {
                    final gudang = _gudangList[index];

                    Widget itemCard = Card(
                      margin: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
                      elevation: 3,
                      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
                      child: ListTile(
                        contentPadding: const EdgeInsets.all(16),
                        title: Text(gudang['nama_gudang'] ?? "", style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 18)),
                        subtitle: Padding(
                          padding: const EdgeInsets.only(top: 8.0),
                          child: Column(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              Text("Jenis: ${gudang['jenis_gudang'] != null ? gudang['jenis_gudang']['nama_jenis_gudang'] : '-'}"),
                              const SizedBox(height: 4),
                              Text("Luas: ${gudang['luas_gudang']} m²  |  Volume: ${gudang['volume_gudang']} m³"),
                              if (gudang['keterangan'] != null) ...[
                                const SizedBox(height: 4),
                                Text("Ket: ${gudang['keterangan']}", style: const TextStyle(fontStyle: FontStyle.italic)),
                              ]
                            ],
                          ),
                        ),
                        trailing: isAdmin
                            ? IconButton(
                                icon: const Icon(Icons.edit, color: Colors.orange),
                                onPressed: () {
                                  Navigator.push(
                                    context,
                                    MaterialPageRoute(builder: (context) => FormGudangScreen(gudangData: gudang)),
                                  ).then((_) => _fetchGudangData());
                                },
                              )
                            : null,
                      ),
                    );

                    if (isAdmin) {
                      return Dismissible(
                        key: Key(gudang['id'].toString()),
                        direction: DismissDirection.startToEnd, 
                        
                        background: Container(
                          color: Colors.red,
                          alignment: Alignment.centerLeft,
                          padding: const EdgeInsets.only(left: 24.0),
                          child: const Icon(Icons.delete, color: Colors.white, size: 32),
                        ),
                        
                        confirmDismiss: (direction) async {
                          return await showDialog(
                            context: context,
                            builder: (context) => AlertDialog(
                              title: const Text("Hapus Data Gudang?"),
                              content: Text("Apakah Anda yakin ingin menghapus ${gudang['nama_gudang']}?"),
                              actions: [
                                TextButton(onPressed: () => Navigator.pop(context, false), child: const Text("Batal")),
                                TextButton(
                                  onPressed: () => Navigator.pop(context, true),
                                  child: const Text("Hapus", style: TextStyle(color: Colors.red)),
                                ),
                              ],
                            ),
                          );
                        },
                        onDismissed: (direction) {
                          _deleteGudang(gudang['id'], index);
                        },
                        child: itemCard,
                      );
                    }

                    return itemCard;
                  },
                ),
    );
  }
}