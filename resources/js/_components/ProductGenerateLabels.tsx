import { Printer, RefreshCw } from "lucide-react";

export default function ProductGenerateLabels({ processing, disabled, onGenerate }: {
    processing?: boolean;
    disabled?: boolean;
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
                <button
                    type="button"
                    className="mt-4 btn btn-primary btn-block"
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