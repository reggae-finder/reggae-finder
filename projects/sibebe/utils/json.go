package utils

import (
    _"fmt"
    "bytes"
    "encoding/json"
    "strconv"
    "strings"
)

func ToJsonString(object interface{}, format bool) (string, error) {
    jsonData, marshalErr := json.Marshal(object)
    if marshalErr != nil {
        return "", marshalErr
    }

    if format {
        var out bytes.Buffer
        json.Indent(&out, jsonData, "", "\t")
        jsonData = out.Bytes()
    }

    jsonString := string(jsonData[:])

    unquotedString, unquoteErr := strconv.Unquote(strings.Replace(strconv.Quote(string(jsonString)), `\\u`, `\u`, -1))
    if unquoteErr != nil {
        return "", unquoteErr
    }

    return unquotedString, nil
}
