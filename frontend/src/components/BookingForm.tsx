// frontend/src/components/BookingForm.tsx
import React, { useState } from 'react';
import { createBooking } from '../api';
import { Slot } from '../types';

export default function BookingForm({ userId, date, slot, onSuccess }:{
  userId: number;
  date: string;
  slot?: Slot;
  onSuccess: (booking: any) => void;
}) {
  const [name, setName] = useState('');
  const [email, setEmail] = useState('');
  const [busy, setBusy] = useState(false);
  const [error, setError] = useState<string | null>(null);

  async function submit(e: React.FormEvent) {
    e.preventDefault();
    if (!slot) return;
    setBusy(true); setError(null);
    try {
      const res = await createBooking({
        userId, date,
        start_time: slot.start,
        end_time: slot.end,
        visitor_name: name,
        visitor_email: email
      });
      onSuccess(res.booking);
      setName(''); setEmail('');
    } catch (err: any) {
      setError(err.message || 'Something went wrong');
    } finally { setBusy(false); }
  }

  return (
    <form onSubmit={submit} className="card">
      <h3>Confirm booking</h3>
      <p>Date: {date} | Time: {slot ? `${slot.start} - ${slot.end}` : 'Select a slot'}</p>

      <div className="field">
        <label className="label">Name</label>
        <input className="input" value={name} onChange={e=>setName(e.target.value)} required />
      </div>
      <div className="field">
        <label className="label">Email</label>
        <input className="input" type="email" value={email} onChange={e=>setEmail(e.target.value)} required />
      </div>

      {error && <p className="error">{error}</p>}
      <button className="primary" disabled={!slot || busy}>{busy ? 'Booking...' : 'Confirm'}</button>
    </form>
  );
}