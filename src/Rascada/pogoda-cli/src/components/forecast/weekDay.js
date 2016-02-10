import humanWeekDay from './humanWeekDay';

export default function($index) {
  let today = new Date().getDay();
  let day = today + $index / 2;
  let night = day != day.toFixed();
  let weekDay = night ? 'noc' : humanWeekDay(day);

  return weekDay;
}
