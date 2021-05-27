package javascript

import (
    "fmt"
    "strings"
)

type JavascriptPack struct {

}

// func (p JavascriptPack) Gather(packages []string) (fmt.Stringer, error) {
//     for path := range packages {
//         fmt.Println(path)
//     }
// }

func (p JavascriptPack) BuildMap(filename string, path string) (string, bool) {
    if filename != "package.json" || strings.Contains(path, "node_module") {
        return "", false
    }

    return path, true
}
