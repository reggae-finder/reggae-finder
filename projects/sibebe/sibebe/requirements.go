package sibebe

import (
    "fmt"

    "github.com/jedib0t/go-pretty/v6/table"
    "github.com/jedib0t/go-pretty/v6/text"
)

/*

RequirementsList
[
    Requirement
    {
        "PackageName": "cool/dependency",
        "Versions":
            RequirementVersions
            {
                "1.0.0":
                    RequirementOrigins
                    [
                        "/path/to/package1/composer.json",
                        "/path/to/package2/composer.json"
                    ]
            }
    }
]

*/

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////    LIST
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

type RequirementsList []Requirement

func (r RequirementsList) hasRequirement(dependency string) bool {
    for _, requirement := range r {
        if requirement.PackageName == dependency {
            return true
        }
    }
    return false
}

func (r RequirementsList) getRequirement(dependency string) (result Requirement, err error) {
    for _, requirement := range r {
        if requirement.PackageName == dependency {
            return requirement, nil
        }
    }
    return result, fmt.Errorf("Could not find requirement for %s", dependency)
}

func (list *RequirementsList) AddRequirement(req Requirement) {
    if list.hasRequirement(req.PackageName) {
        sourceReq, _ := list.getRequirement(req.PackageName)
        sourceReq.merge(req)
    } else {
        *list = append(*list, req)
    }
}

func (list RequirementsList) Analyse() error {
    conflicts := []RequirementConflict{}

    for _, requirement := range list {
        if (len(requirement.Versions) > 1) {
            conflict := RequirementConflict{packageName: requirement.PackageName, conflictingVersions: requirement.Versions}
            conflicts = append(conflicts, conflict)
        }
    }

    if len(conflicts) == 0 {
        return nil
    }

    err := RequirementsConflictsError{conflicts: conflicts}

    return err
}

func (list RequirementsList) ToTableString() string {
    t := table.NewWriter()
    t.SetTitle("Requirements List")
    for _, requirement := range list {
        t.AppendRow(table.Row{requirement.PackageName, requirement.PackageName}, table.RowConfig{AutoMerge: true})
        t.AppendSeparator()

        for version, origins := range requirement.Versions {
            for file, _ := range origins {
                t.AppendRow(table.Row{version, file})
            }
            t.AppendSeparator()
        }
        t.AppendSeparator()
    }
    t.SetColumnConfigs([]table.ColumnConfig{
        {Number: 1, AutoMerge: true},
    })
    t.SetStyle(table.StyleRounded)

    return t.Render()
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////    REQUIREMENT
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

type Requirement struct {
    PackageName string
    Versions RequirementVersions
}

func (req Requirement) hasVersion(version string) bool {
    for reqVersion, _ := range req.Versions {
        if reqVersion == version {
            return true
        }
    }
    return false
}

func (source *Requirement) merge(target Requirement) error {
    if source.PackageName != target.PackageName {
        return fmt.Errorf("Cannot merge requirements for different packages, got %s and %s", source.PackageName, target.PackageName)
    }

    for targetVersion, targetOrigins := range target.Versions {
        if val, ok := source.Versions[targetVersion]; ok {
            val.merge(targetOrigins)
        } else {
            source.Versions[targetVersion] = targetOrigins
        }
    }
    return nil
}

type RequirementVersions map[string]RequirementOrigins

type RequirementOrigins map[string]struct{}

func (source *RequirementOrigins) merge(target RequirementOrigins) {
    for file, _ := range target {
        (*source)[file] = struct{}{}
    }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////    CONFLICTS
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

type RequirementsConflictsError struct {
    conflicts []RequirementConflict
    pack LanguagePack
}

type RequirementConflict struct {
    packageName string
    conflictingVersions  RequirementVersions
}

func (e *RequirementsConflictsError) AddPack(pack LanguagePack) {
    e.pack = pack
}

func (e RequirementsConflictsError) Error() string {
    return e.ToTableString()
}

func (e RequirementsConflictsError) ToTableString() string {
    t := table.NewWriter()
    for _, conflict := range e.conflicts {
        t.AppendRow(table.Row{conflict.packageName, conflict.packageName}, table.RowConfig{AutoMerge: true})
        t.AppendSeparator()

        for version, origins := range conflict.conflictingVersions {
            for file, _ := range origins {
                t.AppendRow(table.Row{version, file})
            }
            t.AppendSeparator()
        }
        t.AppendSeparator()
    }
    t.SetColumnConfigs([]table.ColumnConfig{
        {Number: 1, AutoMerge: true, Align: text.AlignLeft},
        {Number: 2, Align: text.AlignLeft},
    })
    t.SetStyle(table.StyleRounded)

    message := "Conflicts found while gathering dependencies"
    if e.pack != nil {
        message += fmt.Sprintf(" in %T", e.pack)
    }
    message += "\n"

    return message + t.Render()
}
