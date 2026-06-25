class ServiceModel {
  final int id;
  final String name;
  final String? description;
  final int duration;
  final String price;
  final String status;

  ServiceModel({
    required this.id,
    required this.name,
    this.description,
    required this.duration,
    required this.price,
    required this.status,
  });

  factory ServiceModel.fromJson(Map<String, dynamic> json) {
    return ServiceModel(
      id: json['id'],
      name: json['name'],
      description: json['description'],
      duration: json['duration'] is String ? int.parse(json['duration']) : json['duration'],
      price: json['price'].toString(),
      status: json['status'],
    );
  }
}
