// frontend/src/components/SlotList.tsx
import React from 'react';
import { Slot } from '../types';

export default function SlotList({ slots, selected, onSelect }:{
  slots: Slot[];
  selected?: Slot;
  onSelect: (s: Slot) => void;
}) {
  return (
    <div className="slots-grid">
      {slots.map((s, idx) => (
        <button
          key={`${s.start}-${idx}`}
          className={`slot ${s.status} ${selected?.start===s.start ? 'selected' : ''}`}
          disabled={s.status === 'blocked'}
          onClick={() => onSelect(s)}
        >
          {s.start} - {s.end}
        </button>
      ))}
      {slots.length === 0 && <p>No availability for this date.</p>}
    </div>
  );
}