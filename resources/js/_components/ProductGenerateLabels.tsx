import { ChessKing, Printer, RefreshCw } from "lucide-react";

export default function ProductGenerateLabels({ processing, disabled, checked, onCheckedChange, onGenerate }: {
    processing?: boolean;
    disabled?: boolean;
    checked?: boolean;
    onCheckedChange?: (checked: boolean) => void;
    onGenerate?: () => void;
}) {
    return (
        <div className="hidden shadow-sm card bg-base-100 md:block card-sm">
            <div className="card-body">
                <h2 className="card-title">{'Generate'}</h2>
                <p>{'According to the product specifications in CurrentRMS, four types of labels can be generated:'}</p>
                <ul className="pl-10 font-semibold list-disc">
                    <li>{'Tub labels'}</li>
                    <li>{'Nally bin labels - Standard'}</li>
                    <li>{'Nally bin labels - Stored at height'}</li>
                    <li>{'Colour-coded labels'}</li>
                </ul>
                <hr className="my-4" />
                <label className="label whitespace-normal">
                    <input
                        type="checkbox"
                        className="checkbox"
                        checked={checked ?? false}
                        onChange={event => onCheckedChange?.(event.target.checked)}
                    />
                    <span>{'Generate labels for products in the OPS Inventory group'}</span>
                </label>
                <button
                    type="button"
                    className="btn btn-primary btn-block mt-4"
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
        </div>
    );
}