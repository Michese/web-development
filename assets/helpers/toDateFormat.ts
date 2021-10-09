export function toDateFormat(date: string): string {
  return new Date(date + `Z`).toLocaleString('ru-RU', {
    day: 'numeric',
    month: 'numeric',
    year: 'numeric',
  });
}