import { Printer } from "lucide-react";

export default function ProductGenerateLabels({ disabled, onGenerate }: {
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
                    disabled={disabled}
                    onClick={onGenerate}
                >
                    <Printer size={16} />
                    <span>{'Generate labels'}</span>
                </button>
            </div>
        </div>
    );
}