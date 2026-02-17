import { usePage } from "@inertiajs/react";
import hermesLogo from "./../../images/hermes-logo.png";
import mphLogo from "./../../images/mph-logo.png";
import { SharedData } from "@/types";

export default function GuestLayout({ children }: {
    children: React.ReactNode;
}) {
    const { name } = usePage<SharedData>().props;

    return (
        <div className="flex flex-col items-center min-h-screen px-4 pt-6 sm:justify-center sm:pt-0">
            <div className="flex flex-col w-full gap-4 sm:max-w-md">
                <a href="/" title={name}>
                    <img
                        src={hermesLogo}
                        alt={name}
                        className="w-32"
                    />
                </a>
                {children}
                <a href="/" className="self-end" title={'MPH Australia'}>
                    <img
                        src={mphLogo}
                        alt={'MPH Australia'}
                        className="w-14"
                    />
                </a>
            </div>
        </div>
    );
}