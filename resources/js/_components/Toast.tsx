import { useEffect, useState } from "react";
import clsx from "clsx";

export default function Toast({ type, message }: {
    type: 'success' | 'error' | 'warning' | 'info';
    message: string;
}) {
    const [isExiting, setIsExiting] = useState(false);
    const [isRemoved, setIsRemoved] = useState(false);

    useEffect(() => {
        setIsExiting(false);
        setIsRemoved(false);

        const fadeOutTimer = setTimeout(() => setIsExiting(true), 2500);
        const removeTimer = setTimeout(() => setIsRemoved(true), 3000);
        return () => {
            clearTimeout(fadeOutTimer);
            clearTimeout(removeTimer);
        };
    }, [message]);

    if (isRemoved) return null;

    return (
        <div
            className={clsx(
                "toast toast-top toast-end z-20 transition-all duration-500 ease-out",
                isExiting && "opacity-0 translate-x-4 pointer-events-none"
            )}
        >
            <div className={clsx({
                'alert shadow-lg font-semibold': true,
                'alert-success': type === 'success',
                'alert-error': type === 'error',
                'alert-warning': type === 'warning',
                'alert-info': type === 'info',
            })}>
                <span>{message}</span>
            </div>
        </div>
    );
}
