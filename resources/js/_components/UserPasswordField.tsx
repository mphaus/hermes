import { Eye, EyeOff } from "lucide-react";
import { useRef, useState } from "react";
import { usePasswordGenerator } from "@/hooks";
import FormGroup from "@/_components/FormGroup";

export default function UserPasswordField() {
    const passwordInputRef = useRef<HTMLInputElement>(null);
    const generatePassword = usePasswordGenerator();
    const [showPassword, setShowPassword] = useState(false);

    const handleGeneratePassword = () => {
        const password = generatePassword();
        if (passwordInputRef.current) {
            passwordInputRef.current.value = password;
        }
    };

    const handleTogglePassword = () => {
        setShowPassword(!showPassword);
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
                        type={showPassword ? "text" : "password"}
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
                    {showPassword ? <EyeOff size={16} /> : <Eye size={16} />}
                    <span>
                        {showPassword ? 'Hide' : 'Show'}
                    </span>
                </button>
            </div>
        </FormGroup>
    );
}
