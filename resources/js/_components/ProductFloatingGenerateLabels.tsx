import { Printer } from "lucide-react";

export default function ProductFloatingGenerateLabels({ disabled, onGenerate }: {
    disabled?: boolean;
    onGenerate?: () => void;
}) {
    return (
        <div className="fixed z-10 inset-x-4 bottom-4 md:hidden">
            <button
                type="button" className="btn btn-primary btn-lg btn-block"
                disabled={disabled}
                onClick={onGenerate}
            >
                <Printer size={16} />
                <span>{'Generate labels'}</span>
            </button>
        </div>
    );
}