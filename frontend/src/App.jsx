import React, { useEffect, useState } from 'react';
import DatePicker from './components/DatePicker';
import SlotList from './components/SlotList';
import BookingForm from './components/BookingForm';
import { fetchSlots, createAvailability } from './api';
import './styles.css';

const DEFAULT_USER_ID = 1;

export default function App() {
  const [date, setDate] = useState(new Date().toISOString().slice(0,10));
  const [slots, setSlots] = useState([]);
  const [selected, setSelected] = useState(null);
  const [message, setMessage] = useState(null);

  async function load() {
    setMessage(null);
    setSelected(null);
    try {
      const { slots } = await fetchSlots(DEFAULT_USER_ID, date);
      setSlots(slots);
    } catch {
      setSlots([]); 
      setMessage('Failed to load slots');
    }
  }

  useEffect(() => { load(); }, [date]);

  async function seedAvailability() {
    try {
      await createAvailability(DEFAULT_USER_ID, date, '09:00', '17:00', 30);
      await load();
    } catch {
      setMessage('Failed to create availability');
    }
  }

  return (
    <div className="container">
      <h1>Calendly‑mini</h1>
      <DatePicker value={date} onChange={setDate} />
      <div className="actions">
        <button className="secondary" onClick={seedAvailability}>
          Add demo availability (09:00–17:00)
        </button>
      </div>
      <SlotList slots={slots} selected={selected} onSelect={setSelected} />
      <BookingForm
        userId={DEFAULT_USER_ID}
        date={date}
        slot={selected}
        onSuccess={(b) => setMessage(`Booked: ${b.date} ${b.start_time}-${b.end_time} for ${b.visitor_name}`)}
      />
      {message && <p className="notice">{message}</p>}
    </div>
  );
}