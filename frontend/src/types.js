export type Slot = { start: string; end: string; status: 'open' | 'blocked' };
export type BookingPayload = {
  userId: number;
  date: string;         // YYYY-MM-DD
  start_time: string;   // HH:MM
  end_time: string;     // HH:MM
  visitor_name: string;
  visitor_email: string;
};