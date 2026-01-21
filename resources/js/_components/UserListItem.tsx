import { User } from "@/types";

export default function UserListItem({ user }: {
    user: User;
}) {
    return (
        <div className="card card-sm shadow-sm">
            <div className="card-body">
                <div className="grid grid-cols-1 lg:grid-cols-10 gap-2 items-center">
                    {/* Name */}
                    <div className="col-span-2 flex flex-col lg:flex-row lg:items-center">
                        <span className="font-medium">{user.first_name} {user.last_name}</span>
                    </div>
                    {/* Username */}
                    <div className="col-span-2">
                        <span className="text-gray-600">{user.username}</span>
                    </div>
                    {/* Email */}
                    <div className="col-span-3 wrap-break-word">
                        <span className="text-blue-600">{user.email}</span>
                    </div>
                    {/* Is admin */}
                    <div className="flex items-center justify-start lg:justify-center">
                        {user.is_admin ? (
                            <span className="inline-block rounded bg-success text-success-content text-xs px-2 py-0.5 font-semibold">Yes</span>
                        ) : (
                            <span className="inline-block rounded bg-base-300 text-base-content text-xs px-2 py-0.5 font-semibold">No</span>
                        )}
                    </div>
                    {/* Is enabled */}
                    <div className="flex items-center justify-start lg:justify-center">
                        {user.is_enabled ? (
                            <span className="inline-block rounded bg-success text-success-content text-xs px-2 py-0.5 font-semibold">Yes</span>
                        ) : (
                            <span className="inline-block rounded bg-error text-error-content text-xs px-2 py-0.5 font-semibold">No</span>
                        )}
                    </div>
                    {/* Actions */}
                    <div className="flex justify-end space-x-2">
                        <a
                            href={`/users/${user.id}/edit`}
                            className="btn btn-xs btn-outline"
                            title="Edit"
                        >
                            Edit
                        </a>
                        {/* Additional actions can go here */}
                    </div>
                </div>
            </div>
        </div>
    );
}
