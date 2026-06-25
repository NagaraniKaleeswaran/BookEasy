import 'package:flutter/material.dart';
import 'package:intl/intl.dart';
import 'package:provider/provider.dart';
import '../../models/service_model.dart';
import '../../providers/appointment_provider.dart';
import 'booking_details_screen.dart';

class BookingDateTimeScreen extends StatefulWidget {
  final ServiceModel service;
  const BookingDateTimeScreen({super.key, required this.service});

  @override
  State<BookingDateTimeScreen> createState() => _BookingDateTimeScreenState();
}

class _BookingDateTimeScreenState extends State<BookingDateTimeScreen> {
  DateTime _selectedDate = DateTime.now();
  String? _selectedTime;

  @override
  void initState() {
    super.initState();
    _fetchSlots();
  }

  void _fetchSlots() {
    final dateStr = DateFormat('yyyy-MM-dd').format(_selectedDate);
    WidgetsBinding.instance.addPostFrameCallback((_) {
      Provider.of<AppointmentProvider>(context, listen: false).fetchAvailableSlots(widget.service.id, dateStr);
    });
  }

  @override
  Widget build(BuildContext context) {
    final apProvider = context.watch<AppointmentProvider>();

    return Scaffold(
      appBar: AppBar(title: const Text('Select Date & Time')),
      body: Column(
        children: [
          Container(
            color: Theme.of(context).primaryColor.withValues(alpha: 0.05),
            padding: const EdgeInsets.all(16),
            child: Row(
              children: [
                Expanded(
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(widget.service.name, style: const TextStyle(fontSize: 18, fontWeight: FontWeight.bold)),
                      const SizedBox(height: 4),
                      Text('${widget.service.duration} mins • ${widget.service.price}'),
                    ],
                  ),
                ),
              ],
            ),
          ),
          CalendarDatePicker(
            initialDate: _selectedDate,
            firstDate: DateTime.now(),
            lastDate: DateTime.now().add(const Duration(days: 90)),
            onDateChanged: (date) {
              setState(() {
                _selectedDate = date;
                _selectedTime = null;
              });
              _fetchSlots();
            },
          ),
          const Divider(),
          Expanded(
            child: apProvider.isLoadingSlots
                ? const Center(child: CircularProgressIndicator())
                : apProvider.slotsError != null
                    ? Center(child: Text(apProvider.slotsError!, style: const TextStyle(color: Colors.red)))
                    : apProvider.availableSlots.isEmpty
                        ? const Center(child: Text('No available slots for this date.'))
                        : GridView.builder(
                            padding: const EdgeInsets.all(16),
                            gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
                              crossAxisCount: 3,
                              childAspectRatio: 2.5,
                              crossAxisSpacing: 10,
                              mainAxisSpacing: 10,
                            ),
                            itemCount: apProvider.availableSlots.length,
                            itemBuilder: (context, index) {
                              final slot = apProvider.availableSlots[index];
                              final isSelected = _selectedTime == slot;
                              return InkWell(
                                onTap: () => setState(() => _selectedTime = slot),
                                child: Container(
                                  decoration: BoxDecoration(
                                    color: isSelected ? Theme.of(context).primaryColor : Colors.white,
                                    border: Border.all(color: Theme.of(context).primaryColor),
                                    borderRadius: BorderRadius.circular(8),
                                  ),
                                  alignment: Alignment.center,
                                  child: Text(
                                    slot.substring(0, 5),
                                    style: TextStyle(
                                      color: isSelected ? Colors.white : Theme.of(context).primaryColor,
                                      fontWeight: isSelected ? FontWeight.bold : FontWeight.normal,
                                    ),
                                  ),
                                ),
                              );
                            },
                          ),
          ),
          Padding(
            padding: const EdgeInsets.all(16),
            child: SizedBox(
              width: double.infinity,
              child: ElevatedButton(
                onPressed: _selectedTime == null
                    ? null
                    : () {
                        Navigator.push(
                          context,
                          MaterialPageRoute(
                            builder: (_) => BookingDetailsScreen(
                              service: widget.service,
                              date: DateFormat('yyyy-MM-dd').format(_selectedDate),
                              time: _selectedTime!,
                            ),
                          ),
                        );
                      },
                child: const Text('Continue'),
              ),
            ),
          )
        ],
      ),
    );
  }
}
