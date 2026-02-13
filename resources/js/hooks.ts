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

export function usePasswordGenerator() {
    const generatePassword = useCallback((): string => {
        const numbers = "0123456789";
        const uppercase = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        const lowercase = "abcdefghijklmnopqrstuvwxyz";
        const special = "!@#$%*()_+";
        
        // Ensure we have at least 2 of each required type
        const passwordChars: string[] = [
            ...Array.from({ length: 2 }, () => numbers[Math.floor(Math.random() * numbers.length)]),
            ...Array.from({ length: 2 }, () => uppercase[Math.floor(Math.random() * uppercase.length)]),
            ...Array.from({ length: 2 }, () => lowercase[Math.floor(Math.random() * lowercase.length)]),
            ...Array.from({ length: 2 }, () => special[Math.floor(Math.random() * special.length)]),
        ];
        
        // Fill the rest randomly to reach at least 16 characters
        const allChars = numbers + uppercase + lowercase + special;
        const remainingLength = Math.max(0, 16 - passwordChars.length);
        
        for (let i = 0; i < remainingLength; i++) {
            passwordChars.push(allChars[Math.floor(Math.random() * allChars.length)]);
        }
        
        // Shuffle the array to randomize the order
        for (let i = passwordChars.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [passwordChars[i], passwordChars[j]] = [passwordChars[j], passwordChars[i]];
        }
        
        return passwordChars.join("");
    }, []);

    return generatePassword;
}
