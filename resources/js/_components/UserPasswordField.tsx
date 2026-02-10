import { Eye, EyeOff } from "lucide-react";
import { useRef, useState } from "react";
import { usePasswordGenerator } from "@/hooks";
import FormGroup from "@/_components/FormGroup";
import FormError from "./FormError";

export default function UserPasswordField({ error }: {
    error?: string;
}) {
    const passwordInputRef = useRef<HTMLInputElement>(null);
    const generatePassword = usePasswordGenerator();
    const [hidePassword, setHidePassword] = useState(false);

    const handleGeneratePassword = () => {
        const password = generatePassword();
        if (passwordInputRef.current) {
            passwordInputRef.current.value = password;
        }
    };

    const handleTogglePassword = () => {
        setHidePassword(!hidePassword);
    };

    return (
        <FormGroup>
            <label htmlFor="password">{'Password'}</label>
            <button
                type="button"
                className="btn btn-primary btn-sm btn-soft"
                onClick={handleGeneratePassword}
            >
                {'Generate Password'}
            </button>
            <div className="join flex mt-4">
                <div className="input join-item">
                    <input
                        ref={passwordInputRef}
                        type={hidePassword ? "password" : "text"}
                        id="password"
                        name="password"
                        autoComplete="off"
                    />
                </div>
                <button
                    type="button"
                    className="join-item btn btn-info btn-soft"
                    onClick={handleTogglePassword}
                >
                    {hidePassword ? <EyeOff size={16} /> : <Eye size={16} />}
                    <span>
                        {hidePassword ? 'Show' : 'Hide'}
                    </span>
                </button>
            </div>
            {error && <FormError message={error} />}
        </FormGroup>
    );
}
