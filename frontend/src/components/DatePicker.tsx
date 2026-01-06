// frontend/src/components/DatePicker.tsx
import React from 'react';

export default function DatePicker({ value, onChange }: { value: string; onChange: (v: string) => void }) {
  return (
    <div className="field">
      <label className="label">Pick a date</label>
      <input type="date" value={value} onChange={(e) => onChange(e.target.value)} className="input" />
    </div>
  );
}