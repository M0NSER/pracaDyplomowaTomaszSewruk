<?php


namespace App\Util\FlashBag;


class SystemMessage
{
    const MESSAGE_EMAIL_PASSWORD_IS_INVALID = 'Invalid credentials.';

    const MESSAGE_NEW_SUCCESS = "Inserted successfully";
    const MESSAGE_NEW_FAILURE = "Can not save record";

    const MESSAGE_EDIT_SUCCESS = "Successfully deleted record id: %s";
    const MESSAGE_EDIT_FAILURE = "Can not edit record id: %s";

    const MESSAGE_DELETE_SUCCESS = "Successfully deleted";
    const MESSAGE_DELETE_FAILURE = "Can not delete this record";

    const MESSAGE_CHANGE_STATE_SUCCESS = "Status record id: %s changed successfully";
    const MESSAGE_CHANGE_STATE_FAILURE = "Can not edit record id: %s";

    const MESSAGE_CANNOT_FIND_ITEM = "No record id: %s";

    const MESSAGE_CAN_NOT_GENERATE_REPORT = "Error while generating report";
    const MESSAGE_CAN_NOT_GENERATE_REPORT_WITH_FORMAT = "Can not generate record in format .%s";

    const MESSAGE_SUCCESSFULLY_VOTED = "Successfully voted";
    const MESSAGE_VOTE_SUCCESSFULLY_DELETED = "Vote successfully deleted";
    const MESSAGE_IT_WAS_NOT_POSSIBLE_TO_VOTE = "It was not possible to vote";
    const MESSAGE_CAN_NOT_DELETE_VOTE = "Can not delete this vote";

    const MESSAGE_USER_SUCCESSFULLY_ADDED = "%s user/s successfully added";
    const MESSAGE_CAN_NOT_ADD_USER_TO_TOURNAMENT = "Something went wrong during saving users to tournament";

    const MESSAGE_ALL_USER_ALREADY_EXISTS = "All users already exists";
    const MESSAGE_SOME_USERS_ALREADY_EXISTS = "Some users already exists";

    const MESSAGE_PRIVILEGE_HAS_BEEN_CHANGER_FOR_USER = "Privilege \"%s\" has been added for %s";
    const MESSAGE_PRIVILEGE_CAN_NOT_BE_CHANGED_FOR = "Privilege can not be change for %s";

    const MESSAGE_TOURNAMENT_MUST_HAVE_AT_LEAST_ONE_ADMIN = "Tournament must have at least one admin";

    const MESSAGE_SUCCESSFULLY_SELECTED_PEOPLE = "People has been selected successfully";
    const MESSAGE_CAN_NOT_SELECT_SOME_PEOPLE = "Can not select some people, contact with admin";

    const MESSAGE_SUCCESSFULLY_UNSELECT_PEOPLE = "People has been unselected successfully";
    const MESSAGE_PEOPLE_CAN_NOT_BE_UNSELECTED = "People can not be unselected, contact with admin";

    const MESSAGE_YOU_HAVE_SELECTED_TOO_MUCH_PEOPLE = "You have selected too much people, there is no free slots";

    const MESSAGE_YOUR_CODE_IS = "Your code: %s";

    const MESSAGE_THIS_CODE_DOES_NOT_EXIST_OR_IS_EXPIRED = "This code does not exist or is expired";
    const MESSAGE_SUCCESSFULLY_ADDED_TO_TOURNAMENT = "You have been successfully added to tournament";
    const MESSAGE_YOU_ARE_ALREADY_IN_THIS_TOURNAMENT_OR_YOU_HAVE_BEEN_DELETED = "You are already in this tournament, or you have been deleted";

    const MESSAGE_YOU_HAVE_NO_PERMISSION = 'You have no power here!';

    const LOGIN_FIRST = "Please login first";
}