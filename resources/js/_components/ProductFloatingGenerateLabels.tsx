import { Printer, RefreshCw } from "lucide-react";

export default function ProductFloatingGenerateLabels({ processing, disabled, checked, onCheckedChange, onGenerate }: {
    processing?: boolean;
    disabled?: boolean;
    checked?: boolean;
    onCheckedChange?: (checked: boolean) => void;
    onGenerate?: () => void;
}) {
    return (
        <div className="fixed z-10 inset-x-3 bottom-3 md:hidden bg-white shadow-md p-4 rounded-md">
            <label className="label whitespace-normal text-xs">
                <input
                    type="checkbox"
                    className="checkbox checkbox-sm"
                    checked={checked ?? false}
                    onChange={event => onCheckedChange?.(event.target.checked)}
                />
                <span>{'Generate labels for products in the OPS Inventory group'}</span>
            </label>
            <hr className="my-4" />
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