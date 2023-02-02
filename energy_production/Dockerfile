FROM python:3.10
VOLUME "/tmp"
WORKDIR /app
RUN pip install --upgrade pip
RUN pip install requests
COPY . .
CMD ["python", "-u", "main.py"]
