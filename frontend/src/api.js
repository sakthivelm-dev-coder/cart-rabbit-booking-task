const BASE_URL = import.meta.env.VITE_API_URL || 'http://localhost:8000';

export async function fetchSlots(userId, date) {
  const res = await fetch(`${BASE_URL}/availability?userId=${userId}&date=${date}`);
  if (!res.ok) throw new Error('Failed to fetch availability');
  return res.json(); // returns { slots: [...] }
}

export async function createBooking(payload) {
  const res = await fetch(`${BASE_URL}/bookings`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(payload)
  });
  if (res.status === 409) {
    const body = await res.json();
    throw new Error(body?.error || 'Slot conflict');
  }
  if (!res.ok) throw new Error('Booking failed');
  return res.json();
}

export async function createAvailability(userId, date, start, end, duration) {
  const res = await fetch(`${BASE_URL}/availability`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ userId, date, start_time: start, end_time: end, slot_duration_minutes: duration })
  });
  if (!res.ok) throw new Error('Failed to create availability');
  return res.json();
}