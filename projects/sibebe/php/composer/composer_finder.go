package composer

import(
    "encoding/json"
    "io/ioutil"
    "log"
    "os"
    "path/filepath"
    "strings"
)

func FindComposerJsons(basePath string) map[string]ComposerJson {
    var gathered_jsons = make(map[string]ComposerJson)

    err := filepath.Walk("/home/klein/reggae-finder", func(path string, info os.FileInfo, err error) error {
        if info.Name() != "composer.json" || strings.Contains(path, "vendor") {
            return nil
        }

        content, readErr := ioutil.ReadFile(path)
        if readErr != nil {
            return readErr
        }

        var gathered_json ComposerJson
        jsonErr := json.Unmarshal(content, &gathered_json)
        if jsonErr != nil {
            return jsonErr
        }

        gathered_jsons[path] = gathered_json
        return nil
    })

    if err != nil {
        log.Fatal(err)
    }

    return gathered_jsons
}
