import { useState, useCallback } from "react";

export function useCharacterLimit(max: number) {
    const [ remaining, setRemaining ] = useState(max);

    const handleLimitChange = useCallback(
        (value: string) => {
            setRemaining(max - value.length);
        },
        [ max ]
    );

    const isOverLimit = remaining <= 0;

    return { remaining, isOverLimit, handleLimitChange };
}
