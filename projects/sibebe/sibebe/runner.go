package sibebe

import (
    "fmt"
    "strings"
)

func (s Sibebe) Run(clear bool) error {
    PrintVerbose("Running actions for all packages\n")

    for language, pack := range s.packs {
        if packages, ok := s.packagesMap[language]; ok {
            if err := pack.Run(packages, clear); err != nil {
                return err
            }
        } else {
            PrintVerbose("No packages found for language "+ language)
        }
    }

    return nil
}

func Run(clear bool) error { return s.Run(clear) }

// RunRequest represents a request to run a set of actions in a single package
type RunRequest struct {
    PackageDir string // The directory where the package is located and the actions will be run
    Clear bool // Shall we clear the package of generated artifacts after execution (vendors, ...)
}

// RunResult is the result of running a set of actions in a single package
// The key in the map is the name of the action
type RunResult struct {
    PackageDir string
    ActionResults map[string]ActionResult
}

// Action is a function/callable that can be run in each package
type Action func(packageDir string) ActionResult

// ActionResult is the result of a single action in a given package
type ActionResult struct {
    Name string // Name of the action that was ran, must match the config in .sibebe
    Success bool // Was the action a success or failure
    Output string // The captured output of the action (stdout+stderr)
    Error error // The error that have been generated during the action execution in case of failure
}

// Concatenate the output of all the actions that ran on a single package
func (j RunResult) String() string {
    var outputs []string

    outputs = append(outputs, fmt.Sprintf("Result of the run in %s\n", j.PackageDir))
    for _, result := range j.ActionResults {
        outputs = append(outputs, result.Output)
        if !result.Success && result.Error != nil {
            outputs = append(outputs, result.Error.Error())
        }
    }
    outputs = append(outputs, "\n\n")

    return strings.Join(outputs, "\n")
}

func (j *RunResult) Add(r ActionResult) {
    j.ActionResults[r.Name] = r
}