import { Printer, RefreshCw } from "lucide-react";

export default function ProductFloatingGenerateLabels({ processing, disabled, onGenerate }: {
    processing?: boolean;
    disabled?: boolean;
    onGenerate?: () => void;
}) {
    return (
        <div className="fixed z-10 inset-x-4 bottom-4 md:hidden">
            <button
                type="button" className="btn btn-primary btn-lg btn-block"
                disabled={disabled || processing}
                onClick={onGenerate}
            >
                {processing ? (
                    <>
                        <RefreshCw size={16} className="animate-spin" />
                        <span>{'Generating...'}</span>
                    </>
                ) : (
                    <>
                        <Printer size={16} />
                        <span>{'Generate labels'}</span>
                    </>
                )}
            </button>
        </div>
    );
}