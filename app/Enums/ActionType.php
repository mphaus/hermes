<?php

namespace App\Enums;

enum ActionType: string
{
    case AddedItem = 'create_item';
    case Cancelled = 'cancel';
    case CommentedOnDiscussion = 'comment';
    case CreatedADiscussion = 'discuss';
    case CreatedViaDiscussionEmail = 'discussion_create';
    case Deleted = 'destroy';
    case Erased = 'erase';
    case Updated = 'update';
    case MarkedAsPosrponed = 'mark_as_postponed';
    case MarkedAsDead = 'mark_as_dead';
    case MarkedAsLost = 'mark_as_lost';
}
