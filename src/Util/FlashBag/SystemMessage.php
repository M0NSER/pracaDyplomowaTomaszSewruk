<?php


namespace App\Util\FlashBag;


class SystemMessage
{
    const MESSAGE_NEW_SUCCESS = "Rekord został poprawnie dodany";
    const MESSAGE_NEW_FAILURE = "Nie można zapisać rekordu";

    const MESSAGE_EDIT_SUCCESS = "Rekord id: %s został poprawnie zedytowany";
    const MESSAGE_EDIT_FAILURE = "Nie można zedytować rekordu id: %s";

    const MESSAGE_DELETE_SUCCESS = "Rekord został usunięty pomyślnie";
    const MESSAGE_DELETE_FAILURE = "Rekord nie mógł zostać usunięty";

    const MESSAGE_CHANGE_STATE_SUCCESS = "Status rekordu id: %s został poprawnie zedytowany";
    const MESSAGE_CHANGE_STATE_FAILURE = "Status rekordu id: %s nie mógł zostać zedytowany";

    const MESSAGE_CANNOT_FIND_ITEM = "Brak rekordu o podanym identyfikatorze %s";

    const MESSAGE_SUCCESS_LICENSES_ADDED = "Poprawnie dodano licencję oraz %s przypisań/nia";

    const MESSAGE_SUCCESS_ALERT_HAS_BEEN_TAKEN = "Alert został podjęty";
    const MESSAGE_FAILURE_ALERT_HAS_BEEN_TAKEN = "Alert nie mógł zostać podjęty";
    const MESSAGE_SUCCESS_WITH_INFO_ALERT_HAS_BEEN_TAKEN = "Przejąłeś alert po %s";

    const MESSAGE_CAN_NOT_GENERATE_REPORT = "Błąd przy generowaniu raportu";
    const MESSAGE_CAN_NOT_GENERATE_REPORT_WITH_FORMAT = "Nie można utworzyć raportu w formacie .%s";

    const LOGIN_FIRST = "Please login first";
}