import { useEffect, useState } from 'react';

export default function useMatchMedia(value) {
  const [isBreakpoint, setBreakpoint] = useState(false);

  useEffect(() => {
    let timeoutId = null;
    const resizeListener = () => {
      clearTimeout(timeoutId);
      timeoutId = setTimeout(() => setBreakpoint(window.matchMedia(`(max-width: ${value}px)`).matches), 150);
    };

    window.addEventListener('resize', resizeListener);

    return () => {
      window.removeEventListener('resize', resizeListener);
    };
  }, [value]);

  return isBreakpoint;
}
