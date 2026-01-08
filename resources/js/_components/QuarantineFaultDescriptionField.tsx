import { Info } from "lucide-react";
import { useCharacterLimit } from "@/hooks";
import { useRef } from "react";
import clsx from "clsx";

export default function QuarantineFaultDescriptionField() {
    const MAX = 512;
    const textareaRef = useRef<HTMLTextAreaElement>(null);
    const { remaining, isOverLimit, handleLimitChange } = useCharacterLimit(MAX);

    return (
        <div className="card bg-base-100 shadow-sm">
            <div className="card-body">
                <div className="space-y-4">
                    <label htmlFor="description" className="block font-semibold">{ 'Fault description' }</label>
                    <div className="flex items-start gap-1 mt-2">
                        <Info size={ 16 } className="text-secondary shrink-0" />
                        <p className="text-xs">{ 'Enter a concise, meaningful and objective fault description.' }</p>
                    </div>
                    <textarea
                        name="description"
                        id="description"
                        className="textarea"
                        rows={ 5 }
                        ref={ textareaRef }
                        onChange={ () => handleLimitChange(textareaRef?.current?.value ?? "") }
                    ></textarea>
                    <p className={ clsx({
                        'text-xs font-semibold': true,
                        'text-error': isOverLimit,
                    }) }>
                        { remaining } { remaining === 1 ? 'character' : 'characters' } { 'left' }
                    </p>
                    <div className="space-y-2 text-xs">
                        <p>{ 'Other considerations' }</p>
                        <ul>
                            <li>{ '➡️ Your name will be added to this report automatically, so there\'s no need to add it here.' }</li>
                            <li>{ '➡️ Mention if the correct Job name could not be assigned, and why' }</li>
                            <li>{ '➡️ Mention if a serial number collision 💥 was reported, and what you did about it.' }</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    );
}
