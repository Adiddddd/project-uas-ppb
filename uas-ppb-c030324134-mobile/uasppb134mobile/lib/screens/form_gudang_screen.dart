import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import '../config.dart';

class FormGudangScreen extends StatefulWidget {
  final Map<String, dynamic>? gudangData;

  const FormGudangScreen({Key? key, this.gudangData}) : super(key: key);

  @override
  _FormGudangScreenState createState() => _FormGudangScreenState();
}

class _FormGudangScreenState extends State<FormGudangScreen> {
  final _formKey = GlobalKey<FormState>();
  final TextEditingController _namaController = TextEditingController();
  final TextEditingController _luasController = TextEditingController();
  final TextEditingController _volumeController = TextEditingController();
  final TextEditingController _keteranganController = TextEditingController();

  List<dynamic> _jenisList = [];
  String? _selectedJenisId;
  bool _isLoading = false;

  @override
  void initState() {
    super.initState();
    _fetchJenisGudang();
    if (widget.gudangData != null) {
      _namaController.text = widget.gudangData!['nama_gudang'] ?? "";
      _luasController.text = widget.gudangData!['luas_gudang']?.toString() ?? "";
      _volumeController.text = widget.gudangData!['volume_gudang']?.toString() ?? "";
      _keteranganController.text = widget.gudangData!['keterangan'] ?? "";
      _selectedJenisId = widget.gudangData!['id_jenis_gudang']?.toString();
    }
  }

  Future<void> _fetchJenisGudang() async {
    try {
      final response = await http.get(
        Uri.parse("${AppConfig.baseUrl}/jenis-gudang"),
        headers: {
          "Authorization": "Bearer ${AppConfig.token}",
          "Accept": "application/json"
        },
      );
      
      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        setState(() {
          _jenisList = data['data']; 
        });
      }
    } catch (e) {
      _showSnackBar("Gagal memuat jenis gudang.");
    }
  }

  void _submitData() async {
    if (!_formKey.currentState!.validate() || _selectedJenisId == null) {
      if (_selectedJenisId == null) _showSnackBar("Pilih jenis gudang terlebih dahulu.");
      return;
    }

    setState(() => _isLoading = true);

    bool isEdit = widget.gudangData != null;
    String url = isEdit
        ? "${AppConfig.baseUrl}/gudang/${widget.gudangData!['id']}"
        : "${AppConfig.baseUrl}/gudang";

    Map<String, String> headers = {
      "Authorization": "Bearer ${AppConfig.token}",
      "Content-Type": "application/json",
      "Accept": "application/json",
    };

    Map<String, dynamic> body = {
      "nama_gudang": _namaController.text.trim(),
      "id_jenis_gudang": _selectedJenisId,
      "luas_gudang": _luasController.text.trim(),
      "volume_gudang": _volumeController.text.trim(),
      "keterangan": _keteranganController.text.trim(),
    };

    try {
      http.Response response;
      if (isEdit) {
        response = await http.put(Uri.parse(url), headers: headers, body: jsonEncode(body));
      } else {
        response = await http.post(Uri.parse(url), headers: headers, body: jsonEncode(body));
      }

      if (response.statusCode == 200 || response.statusCode == 201) {
        Navigator.pop(context, true);
      } else {
        _showSnackBar("Gagal menyimpan data ke server.");
      }
    } catch (e) {
      _showSnackBar("Terjadi kesalahan koneksi.");
    } finally {
      setState(() => _isLoading = false);
    }
  }

  void _showSnackBar(String message) {
    ScaffoldMessenger.of(context).showSnackBar(SnackBar(content: Text(message)));
  }

  @override
  Widget build(BuildContext context) {
    bool isEdit = widget.gudangData != null;

    return Scaffold(
      appBar: AppBar(
        title: Text(isEdit ? "Edit Data Gudang" : "Tambah Data Gudang", style: const TextStyle(color: Colors.white, fontWeight: FontWeight.bold)),
        backgroundColor: const Color(0xFF1E293B),
        iconTheme: const IconThemeData(color: Colors.white),
      ),
      body: _isLoading
          ? const Center(child: CircularProgressIndicator())
          : Padding(
              padding: const EdgeInsets.all(16.0),
              child: Form(
                key: _formKey,
                child: ListView(
                  children: [
                    TextFormField(
                      controller: _namaController,
                      decoration: const InputDecoration(labelText: "Nama Gudang", border: OutlineInputBorder()),
                      validator: (v) => v!.isEmpty ? "Nama gudang wajib diisi" : null,
                    ),
                    const SizedBox(height: 16),
                    DropdownButtonFormField<String>(
                      value: _selectedJenisId,
                      hint: const Text("-- Pilih Jenis Gudang --"),
                      decoration: const InputDecoration(border: OutlineInputBorder()),
                      items: _jenisList.map((jenis) {
                        return DropdownMenuItem<String>(
                          value: jenis['id'].toString(),
                          child: Text(jenis['nama_jenis_gudang'] ?? ""),
                        );
                      }).toList(),
                      onChanged: (val) => setState(() => _selectedJenisId = val),
                      validator: (v) => v == null ? "Jenis gudang wajib dipilih" : null,
                    ),
                    const SizedBox(height: 16),
                    TextFormField(
                      controller: _luasController,
                      keyboardType: TextInputType.number,
                      decoration: const InputDecoration(labelText: "Luas Gudang (m²)", border: OutlineInputBorder()),
                      validator: (v) => v!.isEmpty ? "Luas gudang wajib diisi" : null,
                    ),
                    const SizedBox(height: 16),
                    TextFormField(
                      controller: _volumeController,
                      keyboardType: TextInputType.number,
                      decoration: const InputDecoration(labelText: "Volume Gudang (m³)", border: OutlineInputBorder()),
                      validator: (v) => v!.isEmpty ? "Volume gudang wajib diisi" : null,
                    ),
                    const SizedBox(height: 16),
                    TextFormField(
                      controller: _keteranganController,
                      maxLines: 3,
                      decoration: const InputDecoration(labelText: "Keterangan (Opsional)", border: OutlineInputBorder()),
                    ),
                    const SizedBox(height: 32),
                    ElevatedButton(
                      onPressed: _submitData,
                      style: ElevatedButton.styleFrom(
                        backgroundColor: Colors.blue,
                        minimumSize: const Size.fromHeight(50),
                      ),
                      child: Text(
                        isEdit ? "UPDATE DATA" : "SIMPAN DATA",
                        style: const TextStyle(color: Colors.white, fontWeight: FontWeight.bold),
                      ),
                    ),
                  ],
                ),
              ),
            ),
    );
  }
}