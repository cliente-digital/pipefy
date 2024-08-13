# You Need to Know the Company’s Data Schema.
### How Understanding the Data Schema and Maintaining Change Control Can Help Your Company Avoid Losing Efficiency.

---
  This article is part of a series about the features of the [Pipefy plataform](https://www.pipefy.com/) and the integration with applications using the [Clientedigital/Pipefy](https://github.com/cliente-digital/pipefy) php package.
---

tags: #pipefy #integration #php #clientedigital #workflow #bpm


Low-code tools are here to make the work of professionals easier by automating routines and making life simpler for both you and your company. If you are one of those people who can use this type of tool, then you are a  [Citzen Developer](https://www.pipefy.com/blog/what-is-a-citizen-developer/).

The main persona of any low-code product is the citizen developer. They are the ones who make use of the basic and advanced features, and the experience is designed for them. With all those resources, they can bring a company into the digital world, managing the business without paper and pen while maintaining information.

As the use of these tools grows and their success within an organization increases, new challenges arise, and it becomes complex to manage all the resources. This series of articles addresses this complexity, focusing on feature integrations and the day-to-day life of a digital company that utilizes low-code.

  "Everything starts with a pipe (a workflow) and a few fields, and suddenly, there are 10 pipes, many phases, public and private forms, and connections between pipes."

This is the point (or better, before reaching it) where you should start managing not only the processes but your organization as a whole. This is where the challenge of maintaining order comes into play.

This is the moment when the company transitions from being a **light user**  to becoming a **heavy user**.

Questions like these become common:

- How many statuses do we have for sales?
- What does this tag/label mean?
- Is this card in the correct field?
- Where is the document that should be attached?
- ...

How can you prevent your organization from getting lost in the growing number of pipes, phases, fields, and records, eventually losing the efficiency gained initially?

1. Map What Already Exists.
  To map your organization’s data schema, you can use the **cd.pipefy** CLI tool.

  ```bash
  # This command will print the report in markdown
  # directly to stdout.
./vendor/bin/cd.pipefy --config build-schema

# You can redirect stdout to a .md file.

./vendor/bin/cd.pipefy --config build-schema > org-schema.md

# Now you have a markdown file with the schema information.
# If you are sharing this file with stakeholders, it is better
# to convert it to PDF. (On Linux, I use Pandoc)

pandoc org-schema.md -o org-schema.pdf

  ```
When you **execute the build-schema**command, a .json file is generated and saved in your cache (directory .pipefy/.cache/schema.build-***.json). I recommend that you save and version this file for future reference.


You can also edit your report and add explanations about the schema structure.

2. Control the Change.

You can define which users can make changes to your organization’s resources by using permission settings, but this only solves part of the problem, which is **limiting who can make changes**.

The next step is to create a discussion environment where participants are informed about and validate new ideas before execution.

After setting permissions and fostering a culture of sharing and discussing changes, you can also use the JSON schema files and reports to compare and identify changes that have been made.
